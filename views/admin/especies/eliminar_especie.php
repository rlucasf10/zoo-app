<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Eliminar Especie - Session ID: " . session_id());
error_log("Eliminar Especie - Session Data: " . print_r($_SESSION, true));
error_log("Eliminar Especie - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Eliminar Especie - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Eliminar Especie - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Eliminar Especie - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    $_SESSION['mensaje'] = "No se proporcionó ID de especie";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/especies/ver_especies.php");
    exit();
}

$especie_id = $_GET['id'];

// Obtener información de la especie y verificar si tiene animales asociados
try {
    $stmt = $conn->prepare("
        SELECT e.*, COUNT(a.id) as total_animales
        FROM especies e
        LEFT JOIN animales a ON e.id = a.especie_id
        WHERE e.id = ?
        GROUP BY e.id
    ");
    $stmt->execute([$especie_id]);
    $especie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$especie) {
        $_SESSION['mensaje'] = "Especie no encontrada";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: " . BASE_URL . "/views/admin/especies/ver_especies.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error al obtener información de la especie: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener información de la especie";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/especies/ver_especies.php");
    exit();
}

// Procesar la eliminación cuando se confirma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    try {
        // Verificar si hay animales asociados
        if ($especie['total_animales'] > 0) {
            $error = "No se puede eliminar la especie porque tiene animales asociados.";
        } else {
            $stmt = $conn->prepare("DELETE FROM especies WHERE id = ?");
            $stmt->execute([$especie_id]);

            $_SESSION['mensaje'] = "Especie eliminada exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: " . BASE_URL . "/views/admin/especies/ver_especies.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error al eliminar la especie: " . $e->getMessage());
        $error = "Error al eliminar la especie. Por favor, intente nuevamente.";
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/especies/eliminar_especie.css">

<div class="eliminar-especie-header">
    <h1>Eliminar Especie</h1>
    <div class="header-buttons">
        <a href="<?php echo BASE_URL; ?>/views/admin/especies/ver_especies.php" class="btn-action btn-volver">
            <i class="fas fa-arrow-left"></i> Volver a Especies
        </a>
    </div>
</div>

<div class="warning-message">
    <i class="fas fa-exclamation-triangle"></i>
    <strong>¡Advertencia!</strong> Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar esta especie?
</div>

<main class="eliminar-especie-container">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="especie-info">
        <h2>Información de la Especie</h2>
        <div class="info-group">
            <div class="info-label">Nombre</div>
            <div class="info-value"><?php echo htmlspecialchars($especie['nombre_especie']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Descripción</div>
            <div class="info-value"><?php echo htmlspecialchars($especie['descripcion']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Total de Animales</div>
            <div class="info-value"><?php echo $especie['total_animales']; ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Fecha de Creación</div>
            <div class="info-value"><?php echo date('d/m/Y', strtotime($especie['fecha_creacion'])); ?></div>
        </div>
    </div>

    <form method="POST" action="">
        <button type="submit" name="confirmar" class="btn-action btn-confirmar" <?php echo $especie['total_animales'] > 0 ? 'disabled' : ''; ?>>
            <i class="fas fa-trash"></i> Confirmar Eliminación
        </button>
    </form>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>