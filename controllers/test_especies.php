<?php
require_once 'EspeciesController.php';

// Conexión a la base de datos
require_once __DIR__ . '/../config/sql/database.php';

// Crear instancia del controlador
$especiesController = new EspeciesController($pdo);

// Prueba para agregar una especie
echo $especiesController->addSpecies('León', 'El león es conocido como el rey de la selva.');

// Prueba para modificar una especie
echo $especiesController->editSpecies(1, 'León Africano', 'El león africano es una subespecie de león.');

// Prueba para eliminar una especie
echo $especiesController->deleteSpecies(1);

// Prueba para obtener todas las especies
print_r($especiesController->getAllSpecies());

// Prueba para obtener una especie por su ID
print_r($especiesController->getSpeciesById(1));
?>