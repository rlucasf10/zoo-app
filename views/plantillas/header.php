<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../config/sql/database.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Meta etiquetas SEO -->
    <meta name="description"
        content="Zoo App - Un mundo lleno de maravillas naturales y animales fascinantes. Visita nuestro zoológico y disfruta de una experiencia única.">
    <meta name="keywords"
        content="zoológico, animales, conservación, naturaleza, safari, experiencia educativa, zoo app">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Zoo App">
    <meta property="og:title" content="Zoo App - Experiencia única con animales">
    <meta property="og:description"
        content="Descubre la vida salvaje en nuestro zoológico. Actividades educativas, programas de conservación y mucho más.">
    <meta property="og:image" content="<?php echo BASE_URL; ?>/assets/images/logo.png">
    <meta property="og:url" content="https://zooapp.free.nf/zoo-app<?php echo $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">
    <link rel="canonical" href="https://zooapp.free.nf/zoo-app<?php echo $_SERVER['REQUEST_URI']; ?>">
    <title>Zoo App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/index.css">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/assets/images/favicon.png">



    <!-- Definir BASE_URL para JavaScript -->
    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';
    </script>
</head>

<body>
    <header>
        <?php
        error_log("Header - Session ID: " . session_id());
        error_log("Header - Session Data: " . print_r($_SESSION, true));
        error_log("Header - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="<?php echo BASE_URL; ?>/index">Zoo App</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul id="navbar-item" class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/views/inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/views/animales">Animales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/views/itinerarios">Itinerario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/views/reservas">Reservas</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto right-align">
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li class="nav-item dropdown">
                                <?php
                                // Obtener información del usuario desde la base de datos
                                try {
                                    $stmt = $conn->prepare("SELECT nombre_completo FROM usuarios WHERE id = ?");
                                    $stmt->execute([$_SESSION['usuario_id']]);
                                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    error_log("Error al obtener información del usuario: " . $e->getMessage());
                                    $usuario = null;
                                }

                                $nombreUsuario = isset($usuario['nombre_completo']) ? $usuario['nombre_completo'] : 'Usuario';
                                // Extraer solo el primer nombre
                                $primerNombre = explode(' ', $nombreUsuario)[0];
                                ?>
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    title="<?php echo htmlspecialchars($nombreUsuario); ?>">
                                    <i class="fas fa-user"></i>
                                    <span class="user-name"><?php echo htmlspecialchars($primerNombre); ?></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                    <div class="dropdown-header">
                                        <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>/views/user_dashboard.php">
                                        <i class="fas fa-user-circle"></i> Mi Perfil
                                    </a>
                                    <?php if (isset($_SESSION['es_admin']) && ($_SESSION['es_admin'] === true || $_SESSION['es_admin'] === 1)): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/views/admin/admin_dashboard.php">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard
                                        </a>

                                    <?php endif; ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>/views/login_register/logout.php">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                                    </a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Iniciar sesión
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>/views/login_register/login">
                                        <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                                    </a>
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>/views/login_register/register">
                                        <i class="fas fa-user-plus"></i> Registrarse
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Asegurar que los menús desplegables funcionen correctamente
        $(document).ready(function () {
            // Inicializar los dropdowns de Bootstrap
            $('.dropdown-toggle').dropdown();
        });
    </script>