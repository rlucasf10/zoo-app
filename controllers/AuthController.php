<?php
require_once __DIR__ . '/../config/sql/database.php';

class AuthController
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    // Método para iniciar sesión
    public function login($email, $password)
    {
        try {
            $query = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Devuelve solo los datos esenciales del usuario
                return [
                    'id' => $user['id'],
                    'email' => $user['email']
                ];
            } else {
                return false; // Credenciales incorrectas
            }
        } catch (PDOException $e) {
            // Registrar el error en el log del servidor para depuración
            error_log("Error de base de datos: " . $e->getMessage());
            return false;
        }
    }

    // Método para registrar un usuario
    public function register($nombre, $email, $password)
    {
        try {
            // Verificar si el correo ya está registrado
            $query = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                return "El correo electrónico ya está registrado.";
            }

            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario
            $query = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            return "Usuario registrado correctamente.";
        } catch (PDOException $e) {
            error_log("Error de base de datos: " . $e->getMessage());
            return false;
        }
    }
}
?>