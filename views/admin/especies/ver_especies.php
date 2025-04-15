<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Ver Especies - Session ID: " . session_id());
error_log("Ver Especies - Session Data: " . print_r($_SESSION, true));
error_log("Ver Especies - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Ver Especies - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Ver Especies - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Ver Especies - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Obtener todas las especies con información relacionada
try {
    $stmt = $conn->query("
        SELECT e.*, 
               COUNT(DISTINCT a.id) as total_animales
        FROM especies e
        LEFT JOIN animales a ON e.id = a.especie_id
        GROUP BY e.id
        ORDER BY e.id ASC
    ");
    $especies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener especies: " . $e->getMessage());
    $especies = [];
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/especies/ver_especies.css">

<main class="especies-container">
    <div class="especies-header">
        <h1>Gestión de Especies</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/especies/crear_especie.php" class="btn-action btn-crear">
                <i class="fas fa-plus"></i> Crear Nueva Especie
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

    <div class="especies-table-container">
        <?php if (empty($especies)): ?>
            <div class="no-especies">
                <i class="fas fa-leaf"></i>
                <p>No hay especies registradas</p>
            </div>
        <?php else: ?>
            <table class="especies-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Científico</th>
                        <th>Descripción</th>
                        <th>Total Animales</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($especies as $especie): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($especie['id']); ?></td>
                            <td><?php echo htmlspecialchars($especie['nombre_especie']); ?></td>
                            <td><?php echo htmlspecialchars($especie['descripcion'] ?? 'Sin descripción'); ?></td>
                            <td><?php echo $especie['total_animales']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($especie['fecha_creacion'])); ?></td>
                            <td class="acciones">
                                <a href="<?php echo BASE_URL; ?>/views/admin/especies/editar_especie.php?id=<?php echo $especie['id']; ?>"
                                    class="btn-action btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/views/admin/especies/eliminar_especie.php?id=<?php echo $especie['id']; ?>"
                                    class="btn-action btn-delete" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </a>
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