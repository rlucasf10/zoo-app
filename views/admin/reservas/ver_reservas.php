<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Ver Reservas - Session ID: " . session_id());
error_log("Ver Reservas - Session Data: " . print_r($_SESSION, true));
error_log("Ver Reservas - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Ver Reservas - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Ver Reservas - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Ver Reservas - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Obtener todas las reservas con información del usuario
try {
    $stmt = $conn->query("
        SELECT r.*, u.nombre_completo as nombre_usuario, u.email as email_usuario
        FROM reservas r
        JOIN usuarios u ON r.usuario_id = u.id
        ORDER BY r.fecha_visita DESC
    ");
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener reservas: " . $e->getMessage());
    $reservas = [];
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/reservas/ver_reservas.css">

<main class="ver-reservas-container">
    <div class="ver-reservas-header">
        <h1>Gestión de Reservas</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/reservas/crear_reserva.php" class="btn-action btn-crear">
                <i class="fas fa-calendar-plus"></i> Crear Nueva Reserva
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

    <div class="reservas-table-container">
        <?php if (empty($reservas)): ?>
            <div class="no-reservas">
                <i class="fas fa-calendar-times"></i>
                <p>No hay reservas registradas</p>
            </div>
        <?php else: ?>
            <table class="reservas-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Fecha de Visita</th>
                        <th>Cantidad de Personas</th>
                        <th>Tipo de Entrada</th>
                        <th>Precio Total</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['id']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['email_usuario']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($reserva['fecha_visita'])); ?></td>
                            <td><?php echo htmlspecialchars($reserva['cantidad_personas']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['tipo_entrada']); ?></td>
                            <td><?php echo number_format($reserva['precio_total'], 2); ?> €</td>
                            <td><?php echo date('d/m/Y', strtotime($reserva['fecha_creacion'])); ?></td>
                            <td class="action-buttons">
                                <a href="<?php echo BASE_URL; ?>/views/admin/reservas/editar_reserva.php?id=<?php echo $reserva['id']; ?>"
                                    class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/views/admin/reservas/eliminar_reserva.php?id=<?php echo $reserva['id']; ?>"
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