<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Ver Usuarios - Session ID: " . session_id());
error_log("Ver Usuarios - Session Data: " . print_r($_SESSION, true));
error_log("Ver Usuarios - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Ver Usuarios - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Ver Usuarios - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Ver Usuarios - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Obtener todos los usuarios
try {
    $stmt = $conn->query("SELECT id, nombre_completo, nombre_usuario, email, es_admin, fecha_registro FROM usuarios ORDER BY fecha_registro DESC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener usuarios: " . $e->getMessage());
    $usuarios = [];
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/usuarios/ver_usuarios.css">

<main class="usuarios-container">
    <div class="usuarios-header">
        <h1>Gestión de Usuarios</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/crear_usuario.php" class="btn-action btn-crear">
                <i class="fas fa-user-plus"></i> Crear Nuevo Usuario
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

    <div class="usuarios-table-container">
        <?php if (empty($usuarios)): ?>
            <div class="no-usuarios">
                <i class="fas fa-users"></i>
                <p>No hay usuarios registrados</p>
            </div>
        <?php else: ?>
            <table class="usuarios-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Nombre de Usuario</th>
                        <th>Email</th>
                        <th>Tipo de Usuario</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre_completo']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td>
                                <?php if ($usuario['es_admin']): ?>
                                    <span class="badge-admin">Administrador</span>
                                <?php else: ?>
                                    <span class="badge-user">Usuario Normal</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></td>
                            <td class="acciones">
                                <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/editar_usuario.php?id=<?php echo $usuario['id']; ?>"
                                    class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/eliminar_usuario.php?id=<?php echo $usuario['id']; ?>"
                                    class="btn-action btn-delete">
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

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>

<script>
    // Ocultar el mensaje de éxito después de 5 segundos
    document.addEventListener('DOMContentLoaded', function () {
        const mensajeAlerta = document.querySelector('.alert');
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