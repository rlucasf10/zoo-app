<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
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

// Obtener información de la especie
try {
    $stmt = $conn->prepare("SELECT * FROM especies WHERE id = ?");
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

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_especie = trim($_POST['nombre_especie']);
    $descripcion = trim($_POST['descripcion']);
    $errors = [];

    // Validar campos
    if (empty($nombre_especie)) {
        $errors[] = "El nombre de la especie es obligatorio";
    }

    if (empty($descripcion)) {
        $errors[] = "La descripción es obligatoria";
    }

    // Si no hay errores, actualizar la especie
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("UPDATE especies SET nombre_especie = ?, descripcion = ? WHERE id = ?");
            $stmt->execute([$nombre_especie, $descripcion, $especie_id]);

            $_SESSION['mensaje'] = "Especie actualizada exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: " . BASE_URL . "/views/admin/especies/ver_especies.php");
            exit();
        } catch (PDOException $e) {
            error_log("Error al actualizar la especie: " . $e->getMessage());
            $errors[] = "Error al actualizar la especie. Por favor, intente nuevamente.";
        }
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/especies/editar_especie.css">

<main class="editar-especie-container">
    <div class="editar-especie-header">
        <h1>Editar Especie</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/especies/ver_especies.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Especies
            </a>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="form-container">
        <div class="form-group">
            <label for="nombre_especie">Nombre de la Especie</label>
            <input type="text" id="nombre_especie" name="nombre_especie"
                value="<?php echo htmlspecialchars($especie['nombre_especie']); ?>" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="5"
                required><?php echo htmlspecialchars($especie['descripcion']); ?></textarea>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </form>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>