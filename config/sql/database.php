<?php
// Archivo: /config/database.php

// Cargar el autoload de Composer
require_once __DIR__ . '/../../vendor/autoload.php';

// Cargar el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Obtener las variables de entorno desde el archivo .env
$host = $_ENV['DB_HOST'] ?? null;          // Dirección del servidor de base de datos
$dbname = $_ENV['DB_NAME'] ?? null;        // Nombre de la base de datos
$username = $_ENV['DB_USER'] ?? null;      // Nombre de usuario de la base de datos
$password = $_ENV['DB_PASS'] ?? null;      // Contraseña de la base de datos

// Logging de la configuración (sin mostrar la contraseña)
error_log("Intentando conectar a la base de datos:");
error_log("Host: $host");
error_log("Database: $dbname");
error_log("Username: $username");

try {
    // Crear la conexión PDO usando charset=utf8mb4 para una mayor compatibilidad con Unicode
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Configurar PDO para lanzar excepciones en caso de error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Configurar la conexión para usar UTF-8
    $conn->exec("SET NAMES utf8mb4");
    $conn->exec("SET CHARACTER SET utf8mb4");
    $conn->exec("SET character_set_connection=utf8mb4");

    error_log("Conexión a la base de datos establecida correctamente");

} catch (PDOException $e) {
    // Si hay un error, lo capturamos y mostramos un mensaje general
    error_log("Error de conexión a la base de datos: " . $e->getMessage());
    error_log("Código de error: " . $e->getCode());
    die("Error de conexión: " . $e->getMessage());
}
?>