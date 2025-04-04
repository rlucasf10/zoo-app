<?php
require_once __DIR__ . '/../config/sql/database.php';

class ItinerarioController
{
    private $conn;

    public function __construct()
    {
        global $pdo;
        $this->conn = $pdo;
    }

    // Agregar un nuevo itinerario
    public function addItinerary($nombre_itinerario, $descripcion, $duracion, $ruta)
    {
        try {
            // Verificar si el itinerario ya existe
            $checkQuery = "SELECT id FROM itinerarios WHERE nombre_itinerario = :nombre_itinerario";
            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bindParam(':nombre_itinerario', $nombre_itinerario);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "El itinerario ya existe.";
            }

            // Insertar el nuevo itinerario
            $query = "INSERT INTO itinerarios (nombre_itinerario, descripcion, duracion, ruta) VALUES (:nombre_itinerario, :descripcion, :duracion, :ruta)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre_itinerario', $nombre_itinerario);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->bindParam(':ruta', $ruta);

            if ($stmt->execute()) {
                return "Itinerario insertado con éxito.";
            } else {
                return "Error al insertar el itinerario.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Modificar un itinerario existente
    public function editItinerary($id, $nombre_itinerario, $descripcion, $duracion, $ruta)
    {
        try {
            // Verificar si el itinerario existe
            $checkQuery = "SELECT id FROM itinerarios WHERE id = :id";
            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "El itinerario no existe.";
            }

            // Actualizar el itinerario
            $query = "UPDATE itinerarios SET nombre_itinerario = :nombre_itinerario, descripcion = :descripcion, duracion = :duracion, ruta = :ruta WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre_itinerario', $nombre_itinerario);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->bindParam(':ruta', $ruta);

            if ($stmt->execute()) {
                return "Itinerario actualizado con éxito.";
            } else {
                return "Error al actualizar el itinerario.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    // Eliminar un itinerario
    public function deleteItinerary($id)
    {
        try {
            // Verificar si el itinerario existe
            $checkQuery = "SELECT id FROM itinerarios WHERE id = :id";
            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "El itinerario no existe.";
            }

            // Eliminar el itinerario
            $query = "DELETE FROM itinerarios WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return "Itinerario eliminado con éxito.";
            } else {
                return "Error al eliminar el itinerario.";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        }
    }

    public function crearItinerario($nombre, $duracion, $puntosInteres, $usuarioId)
    {
        try {
            error_log("Intentando crear itinerario con los siguientes datos:");
            error_log("Nombre: " . $nombre);
            error_log("Duración: " . $duracion);
            error_log("Puntos de interés: " . print_r($puntosInteres, true));
            error_log("Usuario ID: " . $usuarioId);

            $sql = "INSERT INTO itinerarios (nombre, duracion, puntos_interes, usuario_id) 
                    VALUES (:nombre, :duracion, :puntos_interes, :usuario_id)";

            $stmt = $this->conn->prepare($sql);

            // Convertir el array de puntos de interés a JSON
            $puntosInteresJson = json_encode($puntosInteres);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->bindParam(':puntos_interes', $puntosInteresJson);
            $stmt->bindParam(':usuario_id', $usuarioId);

            $resultado = $stmt->execute();

            if (!$resultado) {
                error_log("Error al ejecutar la consulta: " . print_r($stmt->errorInfo(), true));
                return false;
            }

            error_log("Itinerario creado con éxito. ID: " . $this->conn->lastInsertId());
            return true;
        } catch (PDOException $e) {
            error_log("Error al crear itinerario: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function obtenerItinerariosUsuario($usuarioId)
    {
        try {
            $sql = "SELECT * FROM itinerarios WHERE usuario_id = :usuario_id ORDER BY fecha_creacion DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener itinerarios: " . $e->getMessage());
            return [];
        }
    }
}
?>