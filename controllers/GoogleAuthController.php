<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/sql/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Usar la variable global $base_url
global $base_url;

use Google\Client;
use Google\Service\Oauth2;

class GoogleAuthController
{
    private $client;
    private $db;

    public function __construct()
    {
        global $conn;
        if (!$conn) {
            throw new Exception('La conexión a la base de datos no está disponible');
        }

        $this->db = $conn;
        $this->client = new Client();

        // Verificar variables de entorno
        if (!isset($_ENV['GOOGLE_CLIENT_ID'])) {
            error_log("Error: GOOGLE_CLIENT_ID no está definido en .env");
            throw new Exception('Error de configuración de Google');
        }

        if (!isset($_ENV['GOOGLE_CLIENT_SECRET'])) {
            error_log("Error: GOOGLE_CLIENT_SECRET no está definido en .env");
            throw new Exception('Error de configuración de Google');
        }

        if (!isset($_ENV['GOOGLE_REDIRECT_URI'])) {
            error_log("Error: GOOGLE_REDIRECT_URI no está definido en .env");
            throw new Exception('Error de configuración de Google');
        }

        // Configuración del cliente
        $this->client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $this->client->addScope('email');
        $this->client->addScope('profile');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');

        // Configuración de desarrollo
        $this->client->setHttpClient(new GuzzleHttp\Client([
            'verify' => false,
            'timeout' => 30
        ]));

        error_log("GoogleAuthController inicializado correctamente");
        error_log("Redirect URI: " . $_ENV['GOOGLE_REDIRECT_URI']);
    }

    public function getAuthUrl()
    {
        try {
            $url = $this->client->createAuthUrl();
            error_log("URL de autenticación generada: " . $url);
            return $url;
        } catch (Exception $e) {
            error_log("Error al generar URL de autenticación: " . $e->getMessage());
            throw $e;
        }
    }

    public function handleCallback($code)
    {
        try {
            // Verificar que el código no esté vacío
            if (empty($code)) {
                throw new Exception('El código de autorización está vacío');
            }

            error_log("Iniciando manejo de callback con código: " . $code);

            // Obtener el token de acceso
            $token = $this->client->fetchAccessTokenWithAuthCode($code);
            if (isset($token['error'])) {
                error_log("Error en token de acceso: " . $token['error']);
                throw new Exception('Error al obtener el token de acceso: ' . $token['error']);
            }

            $this->client->setAccessToken($token);
            $oauth2 = new Oauth2($this->client);
            $userInfo = $oauth2->userinfo->get();

            if (!$userInfo) {
                throw new Exception('No se pudo obtener la información del usuario de Google');
            }

            $email = $userInfo->email;
            $nombre = $userInfo->name;
            $nombre_usuario = $userInfo->email; // Usar el email como nombre de usuario por defecto

            if (empty($email) || empty($nombre)) {
                throw new Exception('La información del usuario está incompleta');
            }

            error_log("Información del usuario obtenida - Email: $email, Nombre: $nombre, Nombre de usuario: $nombre_usuario");

            // Verificar si el usuario ya existe
            $stmt = $this->db->prepare("SELECT id, nombre_completo, nombre_usuario, es_admin, email FROM usuarios WHERE email = :email");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                // Usuario existente
                error_log("Usuario existente encontrado - ID: " . $usuario['id']);
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre_completo'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['es_admin'] = $usuario['es_admin'];
                $_SESSION['email'] = $usuario['email'];

                return true;
            } else {
                // Crear nuevo usuario
                error_log("Creando nuevo usuario - Email: $email, Nombre: $nombre");
                $stmt = $this->db->prepare("INSERT INTO usuarios (nombre_completo, nombre_usuario, email, password) VALUES (:nombre_completo, :nombre_usuario, :email, :password)");
                $password_hash = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
                $stmt->bindValue(':nombre_completo', $nombre, PDO::PARAM_STR);
                $stmt->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $usuario_id = $this->db->lastInsertId();
                    error_log("Nuevo usuario creado - ID: $usuario_id");
                    $_SESSION['usuario_id'] = $usuario_id;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['nombre_usuario'] = $nombre_usuario;
                    $_SESSION['es_admin'] = false;
                    $_SESSION['email'] = $email;

                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            error_log("Error en Google Auth: " . $e->getMessage());
            return false;
        }
    }
}