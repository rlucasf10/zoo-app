<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Crear Itinerario - Session ID: " . session_id());
error_log("Crear Itinerario - Session Data: " . print_r($_SESSION, true));
error_log("Crear Itinerario - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Crear Itinerario - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Crear Itinerario - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Crear Itinerario - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Obtener lista de usuarios para el select
try {
    $stmt = $conn->query("SELECT id, nombre FROM usuarios ORDER BY nombre");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener usuarios: " . $e->getMessage());
    $usuarios = [];
}

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
        error_log("Crear Itinerario - Token no coincide: " . $_POST['form_token'] . " vs " . $_SESSION['form_token']);
    } else {
        // Generar un nuevo token para el próximo envío
        $_SESSION['form_token'] = bin2hex(random_bytes(32));

        $nombre = trim($_POST['nombre'] ?? '');
        $duracion = intval($_POST['duracion'] ?? 0);
        $puntos_interes = isset($_POST['puntos_interes']) ? $_POST['puntos_interes'] : [];
        $usuario_id = $_POST['usuario_id'] ?? null;

        // Validaciones
        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio";
        }

        if ($duracion <= 0) {
            $errores[] = "La duración debe ser mayor a 0";
        }

        if (empty($puntos_interes)) {
            $errores[] = "Debe seleccionar al menos un punto de interés";
        }

        if (empty($errores)) {
            try {
                // Convertir el array de puntos de interés a JSON para almacenarlo
                $puntos_interes_json = json_encode($puntos_interes);

                $stmt = $conn->prepare("
                    INSERT INTO itinerarios (
                        nombre, duracion, puntos_interes, usuario_id, fecha_creacion
                    ) VALUES (?, ?, ?, ?, NOW())
                ");

                $stmt->execute([
                    $nombre,
                    $duracion,
                    $puntos_interes_json,
                    $usuario_id ?: null
                ]);

                $_SESSION['mensaje'] = "Itinerario creado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";

                // Redireccionar y salir
                header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
                exit();
            } catch (PDOException $e) {
                error_log("Error al crear itinerario: " . $e->getMessage());
                $errores[] = "Error al crear el itinerario. Por favor, intente nuevamente.";
            }
        }
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/itinerarios/crear_itinerario.css">

<main class="crear-itinerario-container">
    <div class="crear-itinerario-header">
        <h1>Crear Nuevo Itinerario</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/ver_itinerarios.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Itinerarios
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
        <form method="POST" action="" id="formItinerario">
            <!-- Token oculto para prevenir envíos duplicados -->
            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">

            <div class="form-group">
                <label for="nombre">Nombre del Itinerario *</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="<?php echo htmlspecialchars($nombre ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="duracion">Duración (en horas) *</label>
                <input type="number" id="duracion" name="duracion" class="form-control"
                    value="<?php echo htmlspecialchars($duracion ?? ''); ?>" min="1" required>
            </div>

            <div class="form-group">
                <label>Puntos de Interés *</label>
                <div id="puntos-interes-container">
                    <div class="punto-interes-item">
                        <div class="punto-interes-content">
                            <select name="puntos_interes[]" class="form-control punto-interes-select" required>
                                <option value="">Seleccione un punto de interés</option>
                                <option value="mamiferos">Mamíferos</option>
                                <option value="aves">Aves</option>
                                <option value="reptiles">Reptiles</option>
                                <option value="anfibios">Anfibios</option>
                                <option value="peces">Peces</option>
                            </select>
                            <button type="button" class="btn-remove-punto" title="Eliminar punto de interés">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" id="btn-add-punto" class="btn-add-punto">
                    <i class="fas fa-plus"></i> Añadir Punto de Interés
                </button>
                <div class="form-text">
                    Seleccione al menos una categoría de animales para el itinerario
                </div>
            </div>

            <div class="form-group">
                <label for="usuario_id">Usuario Asignado</label>
                <select name="usuario_id" id="usuario_id" class="form-control">
                    <option value="">Seleccione un usuario (opcional)</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id']; ?>">
                            <?php echo htmlspecialchars($usuario['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Crear Itinerario
            </button>
        </form>
    </div>
</main>

<!-- Script para manejar los puntos de interés -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('puntos-interes-container');
        const btnAdd = document.getElementById('btn-add-punto');

        // Función para crear un nuevo punto de interés
        function createPuntoInteres() {
            const div = document.createElement('div');
            div.className = 'punto-interes-item';
            div.innerHTML = `
                <div class="punto-interes-content">
                    <select name="puntos_interes[]" class="form-control punto-interes-select" required>
                        <option value="">Seleccione un punto de interés</option>
                        <option value="mamiferos">Mamíferos</option>
                        <option value="aves">Aves</option>
                        <option value="reptiles">Reptiles</option>
                        <option value="anfibios">Anfibios</option>
                        <option value="peces">Peces</option>
                    </select>
                    <button type="button" class="btn-remove-punto" title="Eliminar punto de interés">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            return div;
        }

        // Agregar nuevo punto de interés
        btnAdd.addEventListener('click', function () {
            container.appendChild(createPuntoInteres());
        });

        // Eliminar punto de interés
        container.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-punto')) {
                const item = e.target.closest('.punto-interes-item');
                if (container.children.length > 1) {
                    item.remove();
                }
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>

</body>

</html>