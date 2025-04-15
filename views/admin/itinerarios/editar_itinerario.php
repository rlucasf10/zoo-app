<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Editar Itinerario - Session ID: " . session_id());
error_log("Editar Itinerario - Session Data: " . print_r($_SESSION, true));
error_log("Editar Itinerario - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Editar Itinerario - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Editar Itinerario - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Editar Itinerario - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

$mensaje = '';
$tipo_mensaje = '';
$itinerario = [
    'nombre' => '',
    'duracion' => 0,
    'puntos_interes' => '[]',
    'usuario_id' => null
];

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    error_log("Editar Itinerario - No se proporcionó ID");
    header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
    exit();
}

$itinerario_id = $_GET['id'];

// Obtener datos del itinerario
try {
    $stmt = $conn->prepare("SELECT * FROM itinerarios WHERE id = ?");
    $stmt->execute([$itinerario_id]);
    $itinerario_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$itinerario_data) {
        error_log("Editar Itinerario - Itinerario no encontrado");
        header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
        exit();
    }

    // Asignar valores del itinerario con valores por defecto si no existen
    $itinerario['nombre'] = $itinerario_data['nombre'] ?? '';
    $itinerario['duracion'] = $itinerario_data['duracion'] ?? 0;
    $itinerario['puntos_interes'] = $itinerario_data['puntos_interes'] ?? '[]';
    $itinerario['usuario_id'] = $itinerario_data['usuario_id'] ?? null;

    // Decodificar los puntos de interés si están en formato JSON
    if (!empty($itinerario['puntos_interes'])) {
        $puntos_interes_decoded = json_decode($itinerario['puntos_interes'], true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $itinerario['puntos_interes'] = $puntos_interes_decoded;
        } else {
            $itinerario['puntos_interes'] = [];
        }
    } else {
        $itinerario['puntos_interes'] = [];
    }

    // Obtener todos los usuarios para el selector
    $stmt = $conn->query("SELECT id, nombre_completo FROM usuarios ORDER BY nombre_completo");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Error al obtener datos del itinerario: " . $e->getMessage());
    header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $duracion = intval($_POST['duracion'] ?? 0);
    $puntos_interes = isset($_POST['puntos_interes']) ? $_POST['puntos_interes'] : [];
    $usuario_id = $_POST['usuario_id'] ?? null;

    // Validaciones
    $errores = [];

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

            $stmt = $conn->prepare("UPDATE itinerarios SET nombre = ?, duracion = ?, puntos_interes = ?, usuario_id = ? WHERE id = ?");
            $stmt->execute([$nombre, $duracion, $puntos_interes_json, $usuario_id ?: null, $itinerario_id]);

            $_SESSION['mensaje'] = "Itinerario actualizado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";

            // Actualizar los datos mostrados
            $itinerario['nombre'] = $nombre;
            $itinerario['duracion'] = $duracion;
            $itinerario['puntos_interes'] = $puntos_interes;
            $itinerario['usuario_id'] = $usuario_id;

            // Redireccionar y salir
            header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
            exit();
        } catch (PDOException $e) {
            error_log("Error al actualizar itinerario: " . $e->getMessage());
            $mensaje = "Error al actualizar el itinerario";
            $tipo_mensaje = "danger";
        }
    } else {
        $mensaje = implode("<br>", $errores);
        $tipo_mensaje = "danger";
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/itinerarios/editar_itinerario.css">

<main class="editar-itinerario-container">
    <div class="editar-itinerario-header">
        <h1>Editar Itinerario</h1>
        <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/ver_itinerarios.php" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver a Itinerarios
        </a>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="" id="formItinerario">
            <div class="form-group">
                <label for="nombre">Nombre del Itinerario *</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="<?php echo htmlspecialchars($itinerario['nombre']); ?>" required>
            </div>

            <div class="form-group">
                <label for="duracion">Duración (en horas) *</label>
                <input type="number" id="duracion" name="duracion" class="form-control"
                    value="<?php echo htmlspecialchars($itinerario['duracion']); ?>" min="1" required>
            </div>

            <div class="form-group">
                <label>Puntos de Interés *</label>
                <div id="puntos-interes-container">
                    <?php
                    $puntos_interes = is_array($itinerario['puntos_interes']) ? $itinerario['puntos_interes'] : [];
                    if (empty($puntos_interes)) {
                        $puntos_interes = [''];
                    }
                    foreach ($puntos_interes as $index => $punto):
                        ?>
                        <div class="punto-interes-item">
                            <div class="punto-interes-content">
                                <select name="puntos_interes[]" class="form-control punto-interes-select" required>
                                    <option value="">Seleccione un punto de interés</option>
                                    <option value="mamiferos" <?php echo $punto === 'mamiferos' ? 'selected' : ''; ?>>
                                        Mamíferos</option>
                                    <option value="aves" <?php echo $punto === 'aves' ? 'selected' : ''; ?>>Aves</option>
                                    <option value="reptiles" <?php echo $punto === 'reptiles' ? 'selected' : ''; ?>>Reptiles
                                    </option>
                                    <option value="anfibios" <?php echo $punto === 'anfibios' ? 'selected' : ''; ?>>
                                        Anfibios</option>
                                    <option value="peces" <?php echo $punto === 'peces' ? 'selected' : ''; ?>>
                                        Peces</option>
                                </select>
                                <?php if ($index > 0): ?>
                                    <button type="button" class="btn-remove-punto" title="Eliminar punto de interés">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
                        <option value="<?php echo $usuario['id']; ?>" <?php echo $usuario['id'] == $itinerario['usuario_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($usuario['nombre_completo']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('puntos-interes-container');
        const btnAddPunto = document.getElementById('btn-add-punto');
        const form = document.getElementById('formItinerario');

        // Función para crear un nuevo punto de interés
        function crearPuntoInteres() {
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
        btnAddPunto.addEventListener('click', function () {
            const nuevoPunto = crearPuntoInteres();
            container.appendChild(nuevoPunto);
        });

        // Eliminar punto de interés
        container.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-punto')) {
                const puntoInteres = e.target.closest('.punto-interes-item');
                if (container.children.length > 1) {
                    puntoInteres.remove();
                } else {
                    alert('Debe mantener al menos un punto de interés');
                }
            }
        });

        // Validar formulario antes de enviar
        form.addEventListener('submit', function (e) {
            const puntosInteres = document.querySelectorAll('.punto-interes-select');
            const valores = Array.from(puntosInteres).map(select => select.value);
            const valoresUnicos = [...new Set(valores)];

            if (valoresUnicos.length !== valores.length) {
                e.preventDefault();
                alert('No puede seleccionar el mismo punto de interés más de una vez');
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>

</body>

</html>