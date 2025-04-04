<?php
// Incluir el archivo del controlador
require_once __DIR__ . '/../controllers/AnimalController.php';

// Crear una instancia del AnimalController
$animalController = new AnimalController();

// Prueba de agregar un animal
echo "<h3>Prueba de agregar un animal</h3>";
echo $animalController->addAnimal('León', 5, 1, 2, '2019-05-20', 'Un león fuerte') . "<br>";

// Prueba de obtener todos los animales
echo "<h3>Prueba de obtener todos los animales</h3>";
$allAnimals = $animalController->getAllAnimals();
echo "<pre>" . print_r($allAnimals, true) . "</pre>";

// Prueba de obtener un animal por ID
echo "<h3>Prueba de obtener un animal por ID</h3>";
$animalById = $animalController->getAnimalById(1); // Usar un ID válido
echo "<pre>" . print_r($animalById, true) . "</pre>";

// Prueba de editar un animal
echo "<h3>Prueba de editar un animal</h3>";
echo $animalController->editAnimal(1, 'León Africano', 6, 1, 2, '2018-04-15', 'Un león africano fuerte') . "<br>";

// Prueba de eliminar un animal
echo "<h3>Prueba de eliminar un animal</h3>";
echo $animalController->deleteAnimal(1) . "<br>";

?>