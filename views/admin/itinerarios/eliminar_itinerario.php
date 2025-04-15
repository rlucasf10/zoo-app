<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Eliminar Itinerario - Session ID: " . session_id());
error_log("Eliminar Itinerario - Session Data: " . print_r($_SESSION, true));
error_log("Eliminar Itinerario - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Eliminar Itinerario - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Eliminar Itinerario - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Eliminar Itinerario - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    error_log("Eliminar Itinerario - No se proporcionó ID");
    header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
    exit();
}

$itinerario_id = $_GET['id'];

// Obtener información del itinerario
try {
    $stmt = $conn->prepare("
        SELECT i.*, u.nombre as nombre_usuario, u.email as email_usuario,
               COUNT(DISTINCT r.id) as total_reservas
        FROM itinerarios i
        LEFT JOIN usuarios u ON i.usuario_id = u.id
        LEFT JOIN reservas r ON i.id = r.itinerario_id
        WHERE i.id = ?
        GROUP BY i.id
    ");
    $stmt->execute([$itinerario_id]);
    $itinerario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$itinerario) {
        error_log("Eliminar Itinerario - Itinerario no encontrado");
        header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
        exit();
    }

    // Decodificar los puntos de interés si están en formato JSON
    if (!empty($itinerario['puntos_interes'])) {
        $puntos_interes_decoded = json_decode($itinerario['puntos_interes'], true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $itinerario['puntos_interes'] = $puntos_interes_decoded;
        }
    }
} catch (PDOException $e) {
    error_log("Error al obtener información del itinerario: " . $e->getMessage());
    header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
    exit();
}

// Procesar la eliminación cuando se confirma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    try {
        // Primero eliminar las reservas asociadas
        $stmt = $conn->prepare("DELETE FROM reservas WHERE itinerario_id = ?");
        $stmt->execute([$itinerario_id]);

        // Luego eliminar el itinerario
        $stmt = $conn->prepare("DELETE FROM itinerarios WHERE id = ?");
        $stmt->execute([$itinerario_id]);

        $_SESSION['mensaje'] = "Itinerario eliminado exitosamente";
        $_SESSION['tipo_mensaje'] = "success";
        header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
        exit();
    } catch (PDOException $e) {
        error_log("Error al eliminar el itinerario: " . $e->getMessage());
        $error = "Error al eliminar el itinerario. Por favor, intente nuevamente.";
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/itinerarios/eliminar_itinerario.css">

<main class="eliminar-itinerario-container">
    <div class="eliminar-itinerario-header">
        <h1>Eliminar Itinerario</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/ver_itinerarios.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Itinerarios
            </a>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="warning-message">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>¡Advertencia!</strong> Esta acción no se puede deshacer. Se eliminarán todas las reservas asociadas a
        este itinerario.
    </div>

    <div class="itinerario-info">
        <h2>Información del Itinerario</h2>
        <div class="info-group">
            <div class="info-label">Nombre</div>
            <div class="info-value"><?php echo htmlspecialchars($itinerario['nombre']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Duración</div>
            <div class="info-value"><?php echo htmlspecialchars($itinerario['duracion']); ?> horas</div>
        </div>
        <div class="info-group">
            <div class="info-label">Puntos de Interés</div>
            <div class="info-value">
                <?php
                if (is_array($itinerario['puntos_interes'])) {
                    echo htmlspecialchars(implode(', ', $itinerario['puntos_interes']));
                } else {
                    echo htmlspecialchars($itinerario['puntos_interes']);
                }
                ?>
            </div>
        </div>
        <div class="info-group">
            <div class="info-label">Usuario Asignado</div>
            <div class="info-value">
                <?php
                if (!empty($itinerario['nombre_usuario'])) {
                    echo htmlspecialchars($itinerario['nombre_usuario']) . ' (' . htmlspecialchars($itinerario['email_usuario']) . ')';
                } else {
                    echo 'No asignado';
                }
                ?>
            </div>
        </div>
        <div class="info-group">
            <div class="info-label">Total de Reservas</div>
            <div class="info-value"><?php echo $itinerario['total_reservas']; ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Fecha de Creación</div>
            <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($itinerario['fecha_creacion'])); ?></div>
        </div>
    </div>

    <form method="POST" action="">
        <button type="submit" name="confirmar" class="btn-action btn-confirmar">
            <i class="fas fa-trash"></i> Confirmar Eliminación
        </button>
    </form>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>