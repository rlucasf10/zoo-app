<?php
ob_start();  // Inicia el almacenamiento en búfer de salida
// Configuración de la aplicación
define('BASE_URL', '/zoo-app');
define('UPLOAD_DIR', __DIR__ . '/../assets/images/');

// Configuración de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

// Configuración de zona horaria
date_default_timezone_set('Europe/Madrid');

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Función para limpiar datos de entrada
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Endpoint para obtener la variable BASE_URL en formato JSON
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(['base_url' => BASE_URL]);
    exit;
}