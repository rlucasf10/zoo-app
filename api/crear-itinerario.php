<?php
session_start();
require_once __DIR__ . '/../controllers/ItinerarioController.php';

header('Content-Type: application/json');

// Depuración de la sesión
error_log("Session ID: " . session_id());
error_log("Session Data: " . print_r($_SESSION, true));

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    error_log("Usuario no autenticado - SESSION['usuario_id'] no está definido");
    http_response_code(401);
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener los datos del cuerpo de la petición
$rawData = file_get_contents('php://input');
error_log("Datos recibidos: " . $rawData);

$data = json_decode($rawData, true);

if (!$data) {
    error_log("Error al decodificar JSON: " . json_last_error_msg());
    http_response_code(400);
    echo json_encode(['error' => 'Datos JSON inválidos']);
    exit;
}

if (!isset($data['nombre']) || !isset($data['duracion']) || !isset($data['puntosInteres'])) {
    error_log("Datos incompletos: " . print_r($data, true));
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

try {
    $itinerarioController = new ItinerarioController();

    $resultado = $itinerarioController->crearItinerario(
        $data['nombre'],
        $data['duracion'],
        $data['puntosInteres'],
        $_SESSION['usuario_id']
    );

    if ($resultado) {
        echo json_encode(['mensaje' => 'Itinerario creado con éxito']);
    } else {
        error_log("Error al crear el itinerario - El controlador devolvió false");
        http_response_code(500);
        echo json_encode(['error' => 'Error al crear el itinerario']);
    }
} catch (Exception $e) {
    error_log("Error en crear-itinerario.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(['error' => 'Error del servidor']);
}