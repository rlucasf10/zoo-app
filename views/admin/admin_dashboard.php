<?php
require_once __DIR__ . '/../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Admin Dashboard - Session ID: " . session_id());
error_log("Admin Dashboard - Session Data: " . print_r($_SESSION, true));
error_log("Admin Dashboard - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Admin Dashboard - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Admin Dashboard - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Admin Dashboard - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../config/sql/database.php';

// Obtener información del usuario
try {
    $stmt = $conn->prepare("SELECT nombre_completo, email, es_admin FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    error_log("Admin Dashboard - Usuario DB: " . print_r($usuario, true));
} catch (PDOException $e) {
    error_log("Error al obtener información del usuario: " . $e->getMessage());
    $usuario = null;
}

// Obtener estadísticas generales
try {
    // Total de usuarios Administradores
    $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios WHERE es_admin = 1");
    $total_usuarios_admin = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    error_log("Admin Dashboard - Total usuarios admin: " . $total_usuarios_admin);

    // Total de usuarios Normales
    $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios WHERE es_admin = 0");
    $total_usuarios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    error_log("Admin Dashboard - Total usuarios normales: " . $total_usuarios);

    // Total de reservas
    $stmt = $conn->query("SELECT COUNT(*) as total FROM reservas");
    $total_reservas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    error_log("Admin Dashboard - Total reservas: " . $total_reservas);

    // Total de itinerarios
    $stmt = $conn->query("SELECT COUNT(*) as total FROM itinerarios");
    $total_itinerarios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    error_log("Admin Dashboard - Total itinerarios: " . $total_itinerarios);

    // Total de animales
    $stmt = $conn->query("SELECT COUNT(*) as total FROM animales");
    $total_animales = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    error_log("Admin Dashboard - Total animales: " . $total_animales);

    // Total de especies
    $stmt = $conn->query("SELECT COUNT(*) as total FROM especies");
    $total_especies = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    error_log("Admin Dashboard - Total especies: " . $total_especies);

    // Últimas reservas
    $stmt = $conn->query("
        SELECT r.*, u.nombre_completo as nombre_usuario 
        FROM reservas r 
        JOIN usuarios u ON r.usuario_id = u.id 
        ORDER BY r.fecha_visita DESC 
        LIMIT 5
    ");
    $ultimas_reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Admin Dashboard - Últimas reservas: " . count($ultimas_reservas));

} catch (PDOException $e) {
    error_log("Error al obtener estadísticas: " . $e->getMessage());
    $total_usuarios = 0;
    $total_reservas = 0;
    $total_itinerarios = 0;
    $total_animales = 0;
    $total_especies = 0;
    $ultimas_reservas = [];
}

// Incluir el header
require_once __DIR__ . '/../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/admin_dashboard.css">

<main class="admin-dashboard">
    <div class="admin-content">
        <!-- Sección de Bienvenida -->
        <section class="welcome-section">
            <h1>Panel de Administración</h1>
            <p>Bienvenido, <?php echo htmlspecialchars($usuario['nombre_completo'] ?? 'Administrador'); ?></p>
        </section>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo $total_usuarios_admin; ?></div>
                <div class="stat-label">Usuarios Administradores Registrados</div>
                <i class="fas fa-users stat-icon"></i>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $total_usuarios; ?></div>
                <div class="stat-label">Usuarios Registrados</div>
                <i class="fas fa-users stat-icon"></i>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?php echo $total_reservas; ?></div>
                <div class="stat-label">Reservas Totales</div>
                <i class="fas fa-calendar-check stat-icon"></i>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $total_itinerarios; ?></div>
                <div class="stat-label">Itinerarios Creados</div>
                <i class="fas fa-route stat-icon"></i>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $total_animales; ?></div>
                <div class="stat-label">Animales Registrados</div>
                <i class="fas fa-paw stat-icon"></i>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $total_especies; ?></div>
                <div class="stat-label">Especies Registradas</div>
                <i class="fas fa-leaf stat-icon"></i>
            </div>
        </div>

        <!-- Grid de Administración -->
        <div class="admin-grid">
            <!-- Gestión de Usuarios -->
            <section class="admin-card">
                <h2>Gestión de Usuarios</h2>
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/ver_usuarios.php" class="btn-action">
                        <i class="fas fa-users"></i> Ver Usuarios
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/crear_usuario.php" class="btn-action">
                        <i class="fas fa-user-plus"></i> Agregar Usuario
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/ver_usuarios.php" class="btn-action">
                        <i class="fas fa-user-edit"></i> Modificar Usuario
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/ver_usuarios.php" class="btn-action">
                        <i class="fas fa-user-minus"></i> Eliminar Usuario
                    </a>
                </div>
            </section>

            <!-- Gestión de Reservas -->
            <section class="admin-card">
                <h2>Gestión de Reservas</h2>
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>/views/admin/reservas/ver_reservas.php" class="btn-action">
                        <i class="fas fa-calendar-check"></i> Ver Reservas
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/reservas/crear_reserva.php" class="btn-action">
                        <i class="fas fa-plus"></i> Agregar Reserva
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/reservas/ver_reservas.php" class="btn-action">
                        <i class="fas fa-edit"></i> Modificar Reserva
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/reservas/ver_reservas.php" class="btn-action">
                        <i class="fas fa-trash"></i> Eliminar Reserva
                    </a>
                </div>
            </section>

            <!-- Gestión de Itinerarios -->
            <section class="admin-card">
                <h2>Gestión de Itinerarios</h2>
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/ver_itinerarios.php" class="btn-action">
                        <i class="fas fa-route"></i> Ver Itinerarios
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/crear_itinerario.php" class="btn-action">
                        <i class="fas fa-plus"></i> Agregar Itinerario
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/ver_itinerarios.php" class="btn-action" <i
                        class="fas fa-edit"></i> Modificar Itinerario
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/itinerarios/ver_itinerarios.php" class="btn-action">
                        <i class="fas fa-trash"></i> Eliminar Itinerario
                    </a>
                </div>
            </section>

            <!-- Gestión de Animales -->
            <section class="admin-card">
                <h2>Gestión de Animales</h2>
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>/views/admin/animales/ver_animales.php" class="btn-action">
                        <i class="fas fa-paw"></i> Ver Animales
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/animales/crear_animal.php" class="btn-action">
                        <i class="fas fa-plus"></i> Agregar Animal
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/animales/ver_animales.php" class="btn-action">
                        <i class="fas fa-edit"></i> Modificar Animal
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/animales/ver_animales.php" class="btn-action">
                        <i class="fas fa-trash"></i> Eliminar Animal
                    </a>
                </div>
            </section>

            <!-- Gestión de Especies -->
            <section class="admin-card">
                <h2>Gestión de Especies</h2>
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>/views/admin/especies/ver_especies.php" class="btn-action">
                        <i class="fas fa-leaf"></i> Ver Especies
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/especies/crear_especie.php" class="btn-action">
                        <i class="fas fa-plus"></i> Agregar Especie
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/especies/ver_especies.php" class="btn-action">
                        <i class="fas fa-edit"></i> Modificar Especie
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/admin/especies/ver_especies.php" class="btn-action">
                        <i class="fas fa-trash"></i> Eliminar Especie
                    </a>
                </div>
            </section>

            <!-- Actividad Reciente -->
            <section class="admin-card">
                <h2>Actividad Reciente</h2>
                <div class="recent-activity">
                    <ul class="activity-list">
                        <?php foreach ($ultimas_reservas as $reserva): ?>
                            <li class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        Nueva reserva de <?php echo htmlspecialchars($reserva['nombre_usuario']); ?>
                                    </div>
                                    <div class="activity-date">
                                        <?php echo date('d/m/Y', strtotime($reserva['fecha_visita'])); ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../plantillas/footer.php'; ?>

</body>

</html>