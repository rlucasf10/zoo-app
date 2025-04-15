<?php
require_once __DIR__ . '/../config/sql/database.php';

class AdminController
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    // Verificar si el usuario es un administrador
    private function isAdmin($userId)
    {
        // Consultar si el usuario es administrador
        $stmt = $this->db->prepare("SELECT es_admin FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;  // El usuario no existe
        }

        return $user['es_admin'] == 1;
    }


    // ========================= USUARIOS ===========================

    // Obtener todos los usuarios
    public function getAllUsers($userId)
    {
        if (!$this->isAdmin($userId)) {
            return "Acceso denegado. Solo los administradores pueden ver todos los usuarios.";
        }

        $stmt = $this->db->prepare("SELECT * FROM usuarios");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar un usuario
    public function deleteUser($userId, $adminId)
    {
        if (!$this->isAdmin($adminId)) {
            return "Acceso denegado. Solo los administradores pueden eliminar usuarios.";
        }

        // Comprobamos si el usuario existe
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Eliminar el usuario
            $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            return $stmt->execute() ? "Usuario eliminado con éxito." : "Error al eliminar el usuario.";
        }

        return "Usuario no encontrado.";
    }

    // ======================== ANIMALES ===========================

    // Obtener todos los animales
    public function getAllAnimals($adminId)
    {
        if (!$this->isAdmin($adminId)) {
            return "Acceso denegado. Solo los administradores pueden ver todos los animales.";
        }

        $stmt = $this->db->prepare("SELECT * FROM animales");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar un animal
    public function deleteAnimal($animalId, $adminId)
    {
        if (!$this->isAdmin($adminId)) {
            return "Acceso denegado. Solo los administradores pueden eliminar animales.";
        }

        // Comprobamos si el animal existe
        $stmt = $this->db->prepare("SELECT id FROM animales WHERE id = :id");
        $stmt->bindParam(':id', $animalId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Eliminar el animal
            $stmt = $this->db->prepare("DELETE FROM animales WHERE id = :id");
            $stmt->bindParam(':id', $animalId);
            return $stmt->execute() ? "Animal eliminado con éxito." : "Error al eliminar el animal.";
        }

        return "Animal no encontrado.";
    }

    // ======================== ITINERARIOS =========================

    // Obtener todos los itinerarios
    public function getAllItineraries($adminId)
    {
        if (!$this->isAdmin($adminId)) {
            return "Acceso denegado. Solo los administradores pueden ver los itinerarios.";
        }

        $stmt = $this->db->prepare("SELECT * FROM itinerarios");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar un itinerario
    public function deleteItinerary($itineraryId, $adminId)
    {
        if (!$this->isAdmin($adminId)) {
            return "Acceso denegado. Solo los administradores pueden eliminar itinerarios.";
        }

        // Comprobamos si el itinerario existe
        $stmt = $this->db->prepare("SELECT id FROM itinerarios WHERE id = :id");
        $stmt->bindParam(':id', $itineraryId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Eliminar el itinerario
            $stmt = $this->db->prepare("DELETE FROM itinerarios WHERE id = :id");
            $stmt->bindParam(':id', $itineraryId);
            return $stmt->execute() ? "Itinerario eliminado con éxito." : "Error al eliminar el itinerario.";
        }

        return "Itinerario no encontrado.";
    }

    // ======================== ESPECIES ===========================

    // Obtener todas las especies
    public function getAllSpecies($adminId)
    {
        if (!$this->isAdmin($adminId)) {
            return "Acceso denegado. Solo los administradores pueden ver las especies.";
        }

        $stmt = $this->db->prepare("SELECT * FROM especies");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar una especie
    public function deleteSpecies($speciesId, $adminId)
    {
        if (!$this->isAdmin($adminId)) {
            return "Acceso denegado. Solo los administradores pueden eliminar especies.";
        }

        // Comprobamos si la especie existe
        $stmt = $this->db->prepare("SELECT id FROM especies WHERE id = :id");
        $stmt->bindParam(':id', $speciesId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Eliminar la especie
            $stmt = $this->db->prepare("DELETE FROM especies WHERE id = :id");
            $stmt->bindParam(':id', $speciesId);
            return $stmt->execute() ? "Especie eliminada con éxito." : "Error al eliminar la especie.";
        }

        return "Especie no encontrada.";
    }
}
?>