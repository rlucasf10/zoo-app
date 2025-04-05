<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir la URL base del proyecto
$base_url = '/zoo-app';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/login_register.css">
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
                <a class="navbar-brand font-weight-bold" href="<?php echo $base_url; ?>/index.php">Zoo App</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul id="navbar-item" class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/views/animales.php">Animales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/views/itinerarios.php">Itinerario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/views/reservas.php">Reservas</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto right-align">
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                    <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="<?php echo $base_url; ?>/views/perfil.php">
                                        <i class="fas fa-user-circle"></i> Mi Perfil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="<?php echo $base_url; ?>/views/login_register/logout.php">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                                    </a>
                                </div>
                            </li>
                            <?php if (isset($_SESSION['es_admin']) && ($_SESSION['es_admin'] === true || $_SESSION['es_admin'] === 1)): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Panel Administrador
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                        <a class="dropdown-item" href="<?php echo $base_url; ?>/views/admin/dashboard.php">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo $base_url; ?>/views/admin/usuarios.php">
                                            <i class="fas fa-users"></i> Gestión de Usuarios
                                        </a>
                                        <a class="dropdown-item" href="<?php echo $base_url; ?>/views/admin/animales.php">
                                            <i class="fas fa-paw"></i> Gestión de Animales
                                        </a>
                                        <a class="dropdown-item" href="<?php echo $base_url; ?>/views/admin/reservas.php">
                                            <i class="fas fa-calendar-check"></i> Gestión de Reservas
                                        </a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Iniciar sesión
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo $base_url; ?>/views/login_register/login.php">
                                        <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                                    </a>
                                    <a class="dropdown-item"
                                        href="<?php echo $base_url; ?>/views/login_register/register.php">
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
</body>

</html>