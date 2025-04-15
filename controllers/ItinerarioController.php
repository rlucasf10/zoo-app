<?php
require_once __DIR__ . '/../config/sql/database.php';

class ItinerarioController
{
    private $db;

    public function __construct()
    {
        global $conn;
        if (!$conn) {
            throw new Exception("No se pudo establecer la conexión a la base de datos");
        }
        $this->db = $conn;
    }

    // Agregar un nuevo itinerario
    public function addItinerary($nombre_itinerario, $descripcion, $duracion, $ruta)
    {
        try {
            // Verificar si el itinerario ya existe
            $checkQuery = "SELECT id FROM itinerarios WHERE nombre_itinerario = :nombre_itinerario";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':nombre_itinerario', $nombre_itinerario);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "El itinerario ya existe.";
            }

            // Insertar el nuevo itinerario
            $query = "INSERT INTO itinerarios (nombre_itinerario, descripcion, duracion, ruta) VALUES (:nombre_itinerario, :descripcion, :duracion, :ruta)";
            $stmt = $this->db->prepare($query);
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
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "El itinerario no existe.";
            }

            // Actualizar el itinerario
            $query = "UPDATE itinerarios SET nombre_itinerario = :nombre_itinerario, descripcion = :descripcion, duracion = :duracion, ruta = :ruta WHERE id = :id";
            $stmt = $this->db->prepare($query);
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
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "El itinerario no existe.";
            }

            // Eliminar el itinerario
            $query = "DELETE FROM itinerarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
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

            // Verificar que los datos sean válidos
            if (empty($nombre) || empty($duracion) || empty($puntosInteres) || empty($usuarioId)) {
                throw new Exception("Todos los campos son requeridos");
            }

            // Verificar que la duración sea un número válido y esté en el rango correcto
            if (!is_numeric($duracion) || $duracion <= 0 || $duracion > 480) {
                throw new Exception("La duración debe ser un número positivo y no puede exceder 480 minutos (8 horas)");
            }

            // Verificar que puntosInteres sea un array
            if (!is_array($puntosInteres)) {
                throw new Exception("Los puntos de interés deben ser un array");
            }

            // Verificar si ya existe un itinerario con el mismo nombre para este usuario
            $checkSql = "SELECT id FROM itinerarios WHERE nombre = :nombre AND usuario_id = :usuario_id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bindParam(':nombre', $nombre);
            $checkStmt->bindParam(':usuario_id', $usuarioId);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                throw new Exception("Ya existe un itinerario con este nombre para este usuario");
            }

            $sql = "INSERT INTO itinerarios (nombre, duracion, puntos_interes, usuario_id) 
                    VALUES (:nombre, :duracion, :puntos_interes, :usuario_id)";

            $stmt = $this->db->prepare($sql);

            // Convertir el array de puntos de interés a JSON
            $puntosInteresJson = json_encode($puntosInteres, JSON_UNESCAPED_UNICODE);
            if ($puntosInteresJson === false) {
                throw new Exception("Error al codificar los puntos de interés");
            }

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->bindParam(':puntos_interes', $puntosInteresJson);
            $stmt->bindParam(':usuario_id', $usuarioId);

            $resultado = $stmt->execute();

            if (!$resultado) {
                $errorInfo = $stmt->errorInfo();
                error_log("Error al ejecutar la consulta: " . print_r($errorInfo, true));
                throw new Exception("Error al crear el itinerario: " . $errorInfo[2]);
            }

            error_log("Itinerario creado con éxito. ID: " . $this->db->lastInsertId());
            return true;
        } catch (Exception $e) {
            error_log("Error al crear itinerario: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    public function obtenerItinerariosUsuario($usuarioId)
    {
        try {
            $sql = "SELECT * FROM itinerarios WHERE usuario_id = :usuario_id ORDER BY fecha_creacion DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener itinerarios: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerItinerarios()
    {
        try {
            if (!isset($_SESSION['usuario_id'])) {
                return [];
            }
            return $this->obtenerItinerariosUsuario($_SESSION['usuario_id']);
        } catch (Exception $e) {
            error_log("Error al obtener itinerarios: " . $e->getMessage());
            return [];
        }
    }
}
?>