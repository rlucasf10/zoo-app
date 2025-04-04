<?php
require_once __DIR__ . '/../config/sql/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Oauth2;

class GoogleAuthController
{
    private $client;
    private $conn;

    public function __construct($conn)
    {
        if (!$conn) {
            throw new Exception('La conexión a la base de datos no está disponible');
        }

        $this->conn = $conn;
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

            if (empty($email) || empty($nombre)) {
                throw new Exception('La información del usuario está incompleta');
            }

            error_log("Información del usuario obtenida - Email: $email, Nombre: $nombre");

            // Verificar si el usuario ya existe
            $stmt = $this->conn->prepare("SELECT id, nombre, es_admin FROM usuarios WHERE email = :email");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                // Usuario existente
                error_log("Usuario existente encontrado - ID: " . $usuario['id']);
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario'] = $email;
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['es_admin'] = $usuario['es_admin'];
                return true;
            } else {
                // Crear nuevo usuario
                error_log("Creando nuevo usuario - Email: $email, Nombre: $nombre");
                $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
                $password_hash = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
                $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $usuario_id = $this->conn->lastInsertId();
                    error_log("Nuevo usuario creado - ID: $usuario_id");
                    $_SESSION['usuario_id'] = $usuario_id;
                    $_SESSION['usuario'] = $email;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['es_admin'] = false;
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