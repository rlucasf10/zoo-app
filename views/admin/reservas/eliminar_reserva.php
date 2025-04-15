<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Eliminar Reserva - Session ID: " . session_id());
error_log("Eliminar Reserva - Session Data: " . print_r($_SESSION, true));
error_log("Eliminar Reserva - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Eliminar Reserva - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Eliminar Reserva - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Eliminar Reserva - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    $_SESSION['mensaje'] = "No se proporcionó ID de reserva";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ver_reservas.php");
    exit();
}

$reserva_id = $_GET['id'];

// Obtener información de la reserva
try {
    $stmt = $conn->prepare("
        SELECT r.*, u.nombre as nombre_usuario, u.email as email_usuario,
               i.nombre as nombre_itinerario, a.nombre_animal
        FROM reservas r
        JOIN usuarios u ON r.usuario_id = u.id
        LEFT JOIN itinerarios i ON r.itinerario_id = i.id
        LEFT JOIN animales a ON r.animal_id = a.id
        WHERE r.id = ?
    ");
    $stmt->execute([$reserva_id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        $_SESSION['mensaje'] = "Reserva no encontrada";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: ver_reservas.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error al obtener información de la reserva: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener información de la reserva";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ver_reservas.php");
    exit();
}

// Procesar la eliminación cuando se confirma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM reservas WHERE id = ?");
        $stmt->execute([$reserva_id]);

        $_SESSION['mensaje'] = "Reserva eliminada exitosamente";
        $_SESSION['tipo_mensaje'] = "success";
        header("Location: " . BASE_URL . "/views/admin/reservas/ver_reservas.php");
        exit();
    } catch (PDOException $e) {
        error_log("Error al eliminar la reserva: " . $e->getMessage());
        $error = "Error al eliminar la reserva. Por favor, intente nuevamente.";
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/reservas/eliminar_reserva.css">

<main class="eliminar-reserva-container">
    <div class="eliminar-reserva-header">
        <h1>Eliminar Reserva</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/reservas/ver_reservas.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Reservas
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
        <strong>¡Advertencia!</strong> Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar esta
        reserva?
    </div>

    <div class="reserva-info">
        <h2>Información de la Reserva</h2>
        <div class="info-group">
            <div class="info-label">Usuario</div>
            <div class="info-value"><?php echo htmlspecialchars($reserva['nombre_usuario']); ?>
                (<?php echo htmlspecialchars($reserva['email_usuario']); ?>)</div>
        </div>
        <div class="info-group">
            <div class="info-label">Fecha de Visita</div>
            <div class="info-value"><?php echo date('d/m/Y', strtotime($reserva['fecha_visita'])); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Cantidad de Personas</div>
            <div class="info-value"><?php echo htmlspecialchars($reserva['cantidad_personas']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Tipo de Entrada</div>
            <div class="info-value"><?php echo htmlspecialchars($reserva['tipo_entrada']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Precio Total</div>
            <div class="info-value"><?php echo number_format($reserva['precio_total'], 2); ?> €</div>
        </div>
        <?php if ($reserva['nombre_itinerario']): ?>
            <div class="info-group">
                <div class="info-label">Itinerario</div>
                <div class="info-value"><?php echo htmlspecialchars($reserva['nombre_itinerario']); ?></div>
            </div>
        <?php endif; ?>
        <?php if ($reserva['nombre_animal']): ?>
            <div class="info-group">
                <div class="info-label">Animal</div>
                <div class="info-value"><?php echo htmlspecialchars($reserva['nombre_animal']); ?></div>
            </div>
        <?php endif; ?>
    </div>

    <form method="POST" action="">
        <button type="submit" name="confirmar" class="btn-action btn-confirmar">
            <i class="fas fa-trash"></i> Confirmar Eliminación
        </button>
    </form>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>