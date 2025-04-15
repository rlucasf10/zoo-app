<?php
require_once __DIR__ . '/../config/sql/database.php';

class EspeciesController
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    // Agregar una nueva especie
    public function addSpecies($nombre_especie, $descripcion)
    {
        try {
            // Verificar si la especie ya existe
            $checkQuery = "SELECT id FROM especies WHERE nombre_especie = :nombre_especie";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':nombre_especie', $nombre_especie);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "La especie ya existe.";
            }

            // Insertar nueva especie
            $query = "INSERT INTO especies (nombre_especie, descripcion) VALUES (:nombre_especie, :descripcion)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre_especie', $nombre_especie);
            $stmt->bindParam(':descripcion', $descripcion);

            if ($stmt->execute()) {
                return "Especie insertada con éxito.";
            } else {
                return "Error al insertar la especie.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Modificar una especie existente
    public function editSpecies($id, $nombre_especie, $descripcion)
    {
        try {
            // Verificar si la especie existe
            $checkQuery = "SELECT id FROM especies WHERE id = :id";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "La especie no existe.";
            }

            // Actualizar especie
            $query = "UPDATE especies SET nombre_especie = :nombre_especie, descripcion = :descripcion WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre_especie', $nombre_especie);
            $stmt->bindParam(':descripcion', $descripcion);

            if ($stmt->execute()) {
                return "Especie actualizada con éxito.";
            } else {
                return "Error al actualizar la especie.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Eliminar una especie
    public function deleteSpecies($id)
    {
        try {
            // Verificar si la especie existe
            $checkQuery = "SELECT id FROM especies WHERE id = :id";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "La especie no existe.";
            }

            // Eliminar la especie
            $query = "DELETE FROM especies WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return "Especie eliminada con éxito.";
            } else {
                return "Error al eliminar la especie.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Método para obtener todas las especies
    public function getAllSpecies()
    {
        $stmt = $this->db->prepare("SELECT * FROM especies");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener una especie por su ID
    public function getSpeciesById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM especies WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>