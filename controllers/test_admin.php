<?php
// Incluir el controlador AdminController
require_once __DIR__ . '/../controllers/AdminController.php';

// Simulamos que el administrador tiene el ID 1
$adminId = 1;

// Instanciamos el controlador
$adminController = new AdminController();

// Prueba de obtener todos los usuarios
echo "Usuarios:\n";
print_r($adminController->getAllUsers($adminId));

// Prueba de eliminar un usuario (ID 2, por ejemplo)
echo "\nEliminar usuario:\n";
echo $adminController->deleteUser(2, $adminId);

// Prueba de obtener todos los animales
echo "\nAnimales:\n";
print_r($adminController->getAllAnimals($adminId));

// Prueba de eliminar un animal (ID 3, por ejemplo)
echo "\nEliminar animal:\n";
echo $adminController->deleteAnimal(3, $adminId);

// Prueba de obtener todos los itinerarios
echo "\nItinerarios:\n";
print_r($adminController->getAllItineraries($adminId));

// Prueba de eliminar un itinerario (ID 4, por ejemplo)
echo "\nEliminar itinerario:\n";
echo $adminController->deleteItinerary(4, $adminId);

// Prueba de obtener todas las especies
echo "\nEspecies:\n";
print_r($adminController->getAllSpecies($adminId));

// Prueba de eliminar una especie (ID 5, por ejemplo)
echo "\nEliminar especie:\n";
echo $adminController->deleteSpecies(5, $adminId);
?>