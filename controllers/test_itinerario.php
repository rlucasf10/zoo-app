<?php
require_once 'ItinerarioController.php';

// Conexión a la base de datos
require_once __DIR__ . '/../config/sql/database.php';

// Crear instancia del controlador
$itinerarioController = new ItinerarioController();

// Prueba para crear un itinerario
$puntosInteres = json_encode(['mamíferos', 'aves']);
$resultado = $itinerarioController->crearItinerario(
    'Safari Aventura',
    120,
    $puntosInteres,
    1 // ID del usuario de prueba
);

echo "Resultado de crear itinerario: " . ($resultado ? "Éxito" : "Error") . "\n";

// Prueba para obtener itinerarios de un usuario
$itinerarios = $itinerarioController->obtenerItinerariosUsuario(1);
echo "\nItinerarios del usuario:\n";
print_r($itinerarios);