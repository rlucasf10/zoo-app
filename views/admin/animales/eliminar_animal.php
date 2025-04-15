<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Eliminar Animal - Session ID: " . session_id());
error_log("Eliminar Animal - Session Data: " . print_r($_SESSION, true));
error_log("Eliminar Animal - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Eliminar Animal - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Eliminar Animal - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Eliminar Animal - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    $_SESSION['mensaje'] = "No se proporcionó ID de animal";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
    exit();
}

$animal_id = $_GET['id'];

// Obtener información del animal
try {
    $stmt = $conn->prepare("
        SELECT a.*, e.nombre_especie
        FROM animales a
        LEFT JOIN especies e ON a.especie_id = e.id
        WHERE a.id = ?
    ");
    $stmt->execute([$animal_id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        $_SESSION['mensaje'] = "Animal no encontrado";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error al obtener información del animal: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener información del animal";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
    exit();
}

// Procesar la eliminación cuando se confirma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    try {
        // Eliminar la imagen si existe
        if (!empty($animal['imagen_url'])) {
            // Construir la ruta absoluta de la imagen
            $ruta_imagen = __DIR__ . '/../../../' . $animal['imagen_url'];
            $ruta_imagen = str_replace('/', DIRECTORY_SEPARATOR, $ruta_imagen);

            error_log("Intentando eliminar imagen en ruta: " . $ruta_imagen);

            if (file_exists($ruta_imagen)) {
                if (!@unlink($ruta_imagen)) {
                    error_log("Error al eliminar el archivo de imagen: " . error_get_last()['message']);
                } else {
                    error_log("Imagen eliminada exitosamente");
                }
            } else {
                error_log("El archivo de imagen no existe en la ruta: " . $ruta_imagen);
            }
        }

        // Eliminar el animal
        $stmt = $conn->prepare("DELETE FROM animales WHERE id = ?");
        $stmt->execute([$animal_id]);

        $_SESSION['mensaje'] = "Animal eliminado exitosamente";
        $_SESSION['tipo_mensaje'] = "success";
        header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
        exit();
    } catch (PDOException $e) {
        error_log("Error al eliminar el animal: " . $e->getMessage());
        $error = "Error al eliminar el animal. Por favor, intente nuevamente.";
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/animales/eliminar_animal.css">

<main>
    <div class="eliminar-animal-header">
        <h1>Eliminar Animal</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/animales/ver_animales.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Animales
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
        <strong>¡Advertencia!</strong> Esta acción no se puede deshacer. Se eliminará permanentemente el animal y su
        imagen asociada.
    </div>

    <div class="eliminar-animal-container">
        <div class="animal-info">
            <h2>Información del Animal</h2>

            <div class="info-group">
                <div class="info-label">Nombre</div>
                <div class="info-value"><?php echo htmlspecialchars($animal['nombre_animal']); ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Especie</div>
                <div class="info-value"><?php echo htmlspecialchars($animal['nombre_especie'] ?? 'Sin especie'); ?>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Edad</div>
                <div class="info-value"><?php echo $animal['edad'] ? $animal['edad'] . ' años' : 'No especificado'; ?>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Categoría</div>
                <div class="info-value"><?php echo ucfirst($animal['categoria']); ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Hábitat</div>
                <div class="info-value"><?php echo htmlspecialchars($animal['habitat']); ?></div>
            </div>

            <?php if (!empty($animal['imagen_url'])): ?>
                <div class="info-group">
                    <div class="info-label">Imagen actual</div>
                    <div class="imagen-preview-container">
                        <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($animal['imagen_url']); ?>"
                            alt="<?php echo htmlspecialchars($animal['nombre_animal']); ?>" class="imagen-preview">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <form method="POST" action="" class="form-container">
        <button type="submit" name="confirmar" class="btn-action btn-confirmar">
            <i class="fas fa-trash"></i> Confirmar Eliminación
        </button>
    </form>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>