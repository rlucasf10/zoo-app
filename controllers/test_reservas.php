<?php
require_once 'ReservaController.php';

// Conexión a la base de datos
require_once __DIR__ . '/../config/sql/database.php';

// Crear instancia del controlador
$reservaController = new ReservaController($pdo);

// Prueba para agregar una nueva reserva
echo $reservaController->addReservation(1, 1, 1, '2025-04-15', 4);

// Prueba para modificar una reserva
echo $reservaController->editReservation(1, 1, 1, 2, '2025-04-20', 5);

// Prueba para eliminar una reserva
echo $reservaController->deleteReservation(1);

// Prueba para obtener todas las reservas
print_r($reservaController->getAllReservations());

// Prueba para obtener una reserva por su ID
print_r($reservaController->getReservationById(1));
?>