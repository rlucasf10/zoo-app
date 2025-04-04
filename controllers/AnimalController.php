<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../config/sql/database.php';

class AnimalController
{
    // Método para verificar si la especie existe
    private function checkEspecieExists($especie_id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id FROM especies WHERE id = :especie_id");
        $stmt->bindParam(':especie_id', $especie_id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Método para verificar si el itinerario existe
    private function checkItinerarioExists($itinerario_id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id FROM itinerarios WHERE id = :itinerario_id");
        $stmt->bindParam(':itinerario_id', $itinerario_id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Método para obtener todos los animales
    public function getAllAnimals()
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM animales");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener un animal por su ID
    public function getAnimalById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM animales WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para agregar un nuevo animal
    public function addAnimal($nombre_animal, $edad, $especie_id, $itinerario_id, $fecha_nacimiento, $descripcion)
    {
        global $pdo;

        // Verificar si la especie existe
        if (!$this->checkEspecieExists($especie_id)) {
            return "La especie seleccionada no existe.";
        }

        // Verificar si el itinerario existe
        if (!$this->checkItinerarioExists($itinerario_id)) {
            return "El itinerario seleccionado no existe.";
        }

        // Insertar el nuevo animal
        $stmt = $pdo->prepare("INSERT INTO animales (nombre_animal, edad, especie_id, itinerario_id, fecha_nacimiento, descripcion) 
                               VALUES (:nombre_animal, :edad, :especie_id, :itinerario_id, :fecha_nacimiento, :descripcion)");

        $stmt->bindParam(':nombre_animal', $nombre_animal);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':especie_id', $especie_id);
        $stmt->bindParam(':itinerario_id', $itinerario_id);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt->execute() ? "Animal agregado con éxito." : "Error al agregar el animal.";
    }

    // Método para editar un animal
    public function editAnimal($id, $nombre_animal, $edad, $especie_id, $itinerario_id, $fecha_nacimiento, $descripcion)
    {
        global $pdo;

        // Verificar si la especie existe
        if (!$this->checkEspecieExists($especie_id)) {
            return "La especie seleccionada no existe.";
        }

        // Verificar si el itinerario existe
        if (!$this->checkItinerarioExists($itinerario_id)) {
            return "El itinerario seleccionado no existe.";
        }

        // Actualizar el animal
        $stmt = $pdo->prepare("UPDATE animales 
                               SET nombre_animal = :nombre_animal, edad = :edad, especie_id = :especie_id, itinerario_id = :itinerario_id,
                                   fecha_nacimiento = :fecha_nacimiento, descripcion = :descripcion 
                               WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre_animal', $nombre_animal);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':especie_id', $especie_id);
        $stmt->bindParam(':itinerario_id', $itinerario_id);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt->execute() ? "Animal actualizado con éxito." : "Error al actualizar el animal.";
    }

    // Método para eliminar un animal
    public function deleteAnimal($id)
    {
        global $pdo;

        // Verificar si el animal existe
        $stmt = $pdo->prepare("SELECT id FROM animales WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return "El animal con ID $id no existe.";
        }

        // Eliminar el animal
        $stmt = $pdo->prepare("DELETE FROM animales WHERE id = :id");
        $stmt->bindParam(':id', $id);

        return $stmt->execute() ? "Animal eliminado con éxito." : "Error al eliminar el animal.";
    }
}
?>