<?php
require_once __DIR__ . '/../config/sql/database.php';

class ReservaController
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    // Agregar una nueva reserva
    public function addReservation($usuario_id, $itinerario_id, $animal_id, $fecha_visita, $cantidad_personas)
    {
        try {
            // Verificar si la reserva ya existe para ese usuario y fecha de visita
            $checkQuery = "SELECT id FROM reservas WHERE usuario_id = :usuario_id AND fecha_visita = :fecha_visita";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':fecha_visita', $fecha_visita);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Ya existe una reserva para este usuario en la misma fecha.";
            }

            // Insertar nueva reserva
            $query = "INSERT INTO reservas (usuario_id, itinerario_id, animal_id, fecha_visita, cantidad_personas) VALUES (:usuario_id, :itinerario_id, :animal_id, :fecha_visita, :cantidad_personas)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':itinerario_id', $itinerario_id);
            $stmt->bindParam(':animal_id', $animal_id);
            $stmt->bindParam(':fecha_visita', $fecha_visita);
            $stmt->bindParam(':cantidad_personas', $cantidad_personas);

            if ($stmt->execute()) {
                return "Reserva realizada con éxito.";
            } else {
                return "Error al realizar la reserva.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Modificar una reserva existente
    public function editReservation($id, $usuario_id, $itinerario_id, $animal_id, $fecha_visita, $cantidad_personas)
    {
        try {
            // Verificar si la reserva existe
            $checkQuery = "SELECT id FROM reservas WHERE id = :id";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "La reserva no existe.";
            }

            // Actualizar reserva
            $query = "UPDATE reservas SET usuario_id = :usuario_id, itinerario_id = :itinerario_id, animal_id = :animal_id, fecha_visita = :fecha_visita, cantidad_personas = :cantidad_personas WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':itinerario_id', $itinerario_id);
            $stmt->bindParam(':animal_id', $animal_id);
            $stmt->bindParam(':fecha_visita', $fecha_visita);
            $stmt->bindParam(':cantidad_personas', $cantidad_personas);

            if ($stmt->execute()) {
                return "Reserva modificada con éxito.";
            } else {
                return "Error al modificar la reserva.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Eliminar una reserva
    public function deleteReservation($id)
    {
        try {
            // Verificar si la reserva existe
            $checkQuery = "SELECT id FROM reservas WHERE id = :id";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "La reserva no existe.";
            }

            // Eliminar la reserva
            $query = "DELETE FROM reservas WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return "Reserva eliminada con éxito.";
            } else {
                return "Error al eliminar la reserva.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Método para obtener todas las reservas
    public function getAllReservas()
    {
        $stmt = $this->db->prepare("SELECT * FROM reservas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener una reserva por su ID
    public function getReservaById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM reservas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>