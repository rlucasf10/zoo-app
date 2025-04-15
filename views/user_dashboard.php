<?php
require_once __DIR__ . '/../config/config.php';
session_start();
require_once __DIR__ . '/../config/sql/database.php';
require_once __DIR__ . '/plantillas/header.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

// Obtener información del usuario
try {
    $stmt = $conn->prepare("SELECT nombre_completo, email FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener información del usuario: " . $e->getMessage());
    $usuario = null;
}

// Obtener reservas del usuario
try {
    $stmt = $conn->prepare("
        SELECT r.*, i.nombre as nombre_itinerario, a.nombre_animal 
        FROM reservas r 
        LEFT JOIN itinerarios i ON r.itinerario_id = i.id 
        LEFT JOIN animales a ON r.animal_id = a.id 
        WHERE r.usuario_id = ? 
        ORDER BY r.fecha_visita DESC
    ");
    $stmt->execute([$_SESSION['usuario_id']]);
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener reservas: " . $e->getMessage());
    $reservas = [];
}

// Obtener itinerarios creados por el usuario
try {
    $stmt = $conn->prepare("
        SELECT * FROM itinerarios 
        WHERE usuario_id = ? 
        ORDER BY fecha_creacion DESC
    ");
    $stmt->execute([$_SESSION['usuario_id']]);
    $itinerarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener itinerarios: " . $e->getMessage());
    $itinerarios = [];
}
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/user_dashboard.css">



<main class="dashboard-container">
    <!-- Sección de Bienvenida -->
    <section class="welcome-section">
        <?php
        $nombreUsuario = isset($usuario['nombre_completo']) ? $usuario['nombre_completo'] : 'Usuario';

        ?>
        <h1>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></h1>
        <?php if (isset($usuario['email'])): ?>
            <p class="user-email"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($usuario['email']); ?></p>
        <?php endif; ?>
        <p>Aquí puedes gestionar tus reservas e itinerarios</p>
    </section>

    <!-- Grid de secciones -->
    <div class="dashboard-grid">
        <!-- Sección de Reservas -->
        <section class="dashboard-card">
            <h2>Mis Reservas</h2>
            <?php if (empty($reservas)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No tienes reservas pendientes</p>
                    <a href="<?php echo BASE_URL; ?>/views/reservas.php" class="btn-action">Hacer una Reserva</a>
                </div>
            <?php else: ?>
                <?php foreach ($reservas as $reserva): ?>
                    <div class="reserva-item">
                        <div class="reserva-info">
                            <div class="info-item">
                                <span class="info-label">Fecha de Visita</span>
                                <span
                                    class="info-value"><?php echo date('d/m/Y', strtotime($reserva['fecha_visita'])); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tipo de Entrada</span>
                                <span class="info-value"><?php echo htmlspecialchars($reserva['tipo_entrada']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Personas</span>
                                <span class="info-value"><?php echo $reserva['cantidad_personas']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Precio Total</span>
                                <span class="info-value">€<?php echo number_format($reserva['precio_total'], 2); ?></span>
                            </div>
                        </div>
                        <?php if ($reserva['nombre_itinerario']): ?>
                            <div class="info-item">
                                <span class="info-label">Itinerario</span>
                                <span class="info-value"><?php echo htmlspecialchars($reserva['nombre_itinerario']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($reserva['nombre_animal']): ?>
                            <div class="info-item">
                                <span class="info-label">Animal Favorito</span>
                                <span class="info-value"><?php echo htmlspecialchars($reserva['nombre_animal']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- Sección de Itinerarios -->
        <section class="dashboard-card">
            <h2>Mis Itinerarios</h2>
            <?php if (empty($itinerarios)): ?>
                <div class="empty-state">
                    <i class="fas fa-route"></i>
                    <p>No has creado ningún itinerario</p>
                    <a href="<?php echo BASE_URL; ?>/views/itinerarios.php" class="btn-action">Crear Itinerario</a>
                </div>
            <?php else: ?>
                <?php foreach ($itinerarios as $itinerario): ?>
                    <div class="itinerario-item">
                        <div class="itinerario-info">
                            <div class="info-item">
                                <span class="info-label">Nombre</span>
                                <span class="info-value"><?php echo htmlspecialchars($itinerario['nombre']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Duración</span>
                                <span class="info-value"><?php echo $itinerario['duracion']; ?> horas</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Fecha de Creación</span>
                                <span
                                    class="info-value"><?php echo date('d/m/Y', strtotime($itinerario['fecha_creacion'])); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>