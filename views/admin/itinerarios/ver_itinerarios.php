<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Ver Itinerarios - Session ID: " . session_id());
error_log("Ver Itinerarios - Session Data: " . print_r($_SESSION, true));
error_log("Ver Itinerarios - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Ver Itinerarios - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Ver Itinerarios - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Ver Itinerarios - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Verificar ID de itinerario antes de incluir el header
if (isset($_GET['id'])) {
    $itinerario_id = $_GET['id'];
    try {
        // Obtener información del itinerario
        $stmt = $conn->prepare("SELECT * FROM itinerarios WHERE id = ?");
        $stmt->execute([$itinerario_id]);
        $itinerario = $stmt->fetch();

        if (!$itinerario) {
            $_SESSION['mensaje'] = "Itinerario no encontrado";
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error al obtener información del itinerario: " . $e->getMessage());
        $_SESSION['mensaje'] = "Error al obtener información del itinerario";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: " . BASE_URL . "/views/admin/itinerarios/ver_itinerarios.php");
        exit();
    }
}

// Obtener todos los itinerarios con información relacionada
try {
    $stmt = $conn->query("
        SELECT DISTINCT i.id, 
               i.nombre,
               i.duracion,
               i.puntos_interes,
               i.fecha_creacion,
               u.nombre_completo as nombre_usuario,
               (SELECT COUNT(DISTINCT r.id) FROM reservas r WHERE r.itinerario_id = i.id) as total_reservas
        FROM itinerarios i
        LEFT JOIN usuarios u ON i.usuario_id = u.id
        ORDER BY i.fecha_creacion DESC
    ");
    $itinerarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Decodificar los puntos de interés para cada itinerario
    $itinerarios_decoded = [];
    foreach ($itinerarios as $itinerario) {
        if (!empty($itinerario['puntos_interes'])) {
            if (is_string($itinerario['puntos_interes'])) {
                $puntos_interes = json_decode($itinerario['puntos_interes'], true);
            } else {
                $puntos_interes = $itinerario['puntos_interes'];
            }

            if (is_array($puntos_interes)) {
                $puntos_formateados = array_map(function ($punto) {
                    // Reemplazar guiones bajos por espacios y capitalizar cada palabra
                    $punto = str_replace('_', ' ', $punto);
                    return ucwords($punto);
                }, $puntos_interes);
                $itinerario['puntos_interes'] = $puntos_formateados;
            }
        }
        $itinerarios_decoded[] = $itinerario;
    }
    $itinerarios = $itinerarios_decoded;
} catch (PDOException $e) {
    error_log("Error al obtener itinerarios: " . $e->getMessage());
    $itinerarios = [];
}

// Incluir el header después de todas las redirecciones
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/itinerarios/ver_itinerarios.css">

<main class="ver-itinerarios-container">
    <div class="ver-itinerarios-header">
        <h1>Gestión de Itinerarios</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/crear_itinerario.php" class="btn-action btn-crear">
                <i class="fas fa-plus"></i> Crear Nuevo Itinerario
            </a>
            <a href="<?php echo BASE_URL; ?>/views/admin/admin_dashboard.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        </div>
    <?php endif; ?>

    <div class="itinerarios-table-container">
        <?php if (empty($itinerarios)): ?>
            <div class="no-itinerarios">
                <i class="fas fa-route"></i>
                <p>No hay itinerarios registrados</p>
            </div>
        <?php else: ?>
            <table class="itinerarios-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Duración (horas)</th>
                        <th>Puntos de Interés</th>
                        <th>Reservas</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itinerarios as $itinerario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($itinerario['id']); ?></td>
                            <td><?php echo htmlspecialchars($itinerario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($itinerario['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($itinerario['duracion']); ?></td>
                            <td>
                                <?php
                                if (is_array($itinerario['puntos_interes'])) {
                                    $puntos_formateados = array_map(function ($punto) {
                                        // Reemplazar guiones bajos por espacios y capitalizar cada palabra
                                        $punto = str_replace('_', ' ', $punto);
                                        return ucwords($punto);
                                    }, $itinerario['puntos_interes']);
                                    echo htmlspecialchars(implode(", ", $puntos_formateados));
                                } else {
                                    echo "No especificados";
                                }
                                ?>
                            </td>
                            <td><?php echo $itinerario['total_reservas']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($itinerario['fecha_creacion'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/editar_itinerario.php?id=<?php echo $itinerario['id']; ?>"
                                        class="btn-action btn-edit" title="Editar itinerario">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/eliminar_itinerario.php?id=<?php echo $itinerario['id']; ?>"
                                        class="btn-action btn-delete" title="Eliminar itinerario">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<script>
    // Ocultar el mensaje de éxito después de 5 segundos
    document.addEventListener('DOMContentLoaded', function () {
        const mensajeAlerta = document.querySelector('.alert-success');
        if (mensajeAlerta) {
            setTimeout(function () {
                mensajeAlerta.style.opacity = '0';
                mensajeAlerta.style.transition = 'opacity 0.5s ease';
                setTimeout(function () {
                    mensajeAlerta.remove();
                }, 500);
            }, 5000);
        }
    });
</script>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>