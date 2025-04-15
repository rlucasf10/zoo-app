<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Crear Especie - Session ID: " . session_id());
error_log("Crear Especie - Session Data: " . print_r($_SESSION, true));
error_log("Crear Especie - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Crear Especie - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Crear Especie - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Crear Especie - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

$mensaje = '';
$tipo_mensaje = '';
$errores = [];

// Generar un token único para este formulario si no existe
if (!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el token coincide
    if (!isset($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
        $errores[] = "Error de validación del formulario. Por favor, intente nuevamente.";
        error_log("Crear Especie - Token no coincide: " . $_POST['form_token'] . " vs " . $_SESSION['form_token']);
    } else {
        // Generar un nuevo token para el próximo envío
        $_SESSION['form_token'] = bin2hex(random_bytes(32));

        $nombre_especie = trim($_POST['nombre_especie'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        // Validaciones
        if (empty($nombre_especie)) {
            $errores[] = "El nombre de la especie es obligatorio";
        }

        if (empty($descripcion)) {
            $errores[] = "La descripción es obligatoria";
        }

        if (empty($errores)) {
            try {
                $stmt = $conn->prepare("
                    INSERT INTO especies (
                        nombre_especie, descripcion, fecha_creacion
                    ) VALUES (?, ?, NOW())
                ");

                $stmt->execute([
                    $nombre_especie,
                    $descripcion
                ]);

                $_SESSION['mensaje'] = "Especie creada exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
                header("Location: " . BASE_URL . "/views/admin/especies/ver_especies.php");
                exit();
            } catch (PDOException $e) {
                error_log("Error al crear especie: " . $e->getMessage());
                $errores[] = "Error al crear la especie. Por favor, intente nuevamente.";
            }
        }
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/especies/crear_especie.css">

<main class="crear-especie-container">
    <div class="crear-especie-header">
        <h1>Crear Nueva Especie</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/especies/ver_especies.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Especies
            </a>
        </div>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1rem;">
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="" id="formEspecie">
            <!-- Token oculto para prevenir envíos duplicados -->
            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">

            <div class="form-group">
                <label for="nombre_especie">Nombre de la Especie *</label>
                <input type="text" id="nombre_especie" name="nombre_especie" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción *</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Crear Especie
            </button>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formEspecie');

        form.addEventListener('submit', function (e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Por favor, complete todos los campos requeridos.');
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>