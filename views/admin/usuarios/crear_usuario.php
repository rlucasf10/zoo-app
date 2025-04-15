<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Crear Usuario - Session ID: " . session_id());
error_log("Crear Usuario - Session Data: " . print_r($_SESSION, true));
error_log("Crear Usuario - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Crear Usuario - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Crear Usuario - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Crear Usuario - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

$mensaje = '';
$tipo_mensaje = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_completo = trim($_POST['nombre_completo'] ?? '');
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmar_password = $_POST['confirmar_password'] ?? '';
    $es_admin = isset($_POST['es_admin']) ? 1 : 0;

    // Validaciones
    $errores = [];

    if (empty($nombre_completo)) {
        $errores[] = "El nombre completo es obligatorio";
    }

    if (empty($nombre_usuario)) {
        $errores[] = "El nombre de usuario es obligatorio";
    }

    if (empty($email)) {
        $errores[] = "El email es obligatorio";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido";
    }

    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria";
    } elseif (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres";
    }

    if ($password !== $confirmar_password) {
        $errores[] = "Las contraseñas no coinciden";
    }

    // Verificar si el email ya existe
    try {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errores[] = "El email ya está registrado";
        }
    } catch (PDOException $e) {
        error_log("Error al verificar email: " . $e->getMessage());
        $errores[] = "Error al verificar el email";
    }

    // Verificar si el nombre de usuario ya existe
    try {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$nombre_usuario]);
        if ($stmt->fetch()) {
            $errores[] = "El nombre de usuario ya está en uso";
        }
    } catch (PDOException $e) {
        error_log("Error al verificar nombre de usuario: " . $e->getMessage());
        $errores[] = "Error al verificar el nombre de usuario";
    }

    if (empty($errores)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, nombre_usuario, email, password, es_admin, fecha_registro) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$nombre_completo, $nombre_usuario, $email, $hashed_password, $es_admin]);
            
            $_SESSION['mensaje'] = "Usuario creado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: " . BASE_URL . "/views/admin/usuarios/ver_usuarios.php");
            exit();
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            $mensaje = "Error al crear el usuario";
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
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/usuarios/crear_usuario.css">

<main class="crear-usuario-container">
    <div class="crear-usuario-header">
        <h1>Crear Nuevo Usuario</h1>
        <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/ver_usuarios.php" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver a Usuarios
        </a>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?>" id="mensaje-alerta">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo</label>
                <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" 
                       value="<?php echo htmlspecialchars($nombre_completo ?? ''); ?>" required autocomplete="name">
            </div>

            <div class="form-group">
                <label for="nombre_usuario">Nombre de Usuario</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" 
                       value="<?php echo htmlspecialchars($nombre_usuario ?? ''); ?>" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>" required autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                    <button type="button" id="togglePassword" class="password-toggle">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmar_password">Confirmar Contraseña</label>
                <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" required autocomplete="new-password">
            </div>

            <div class="form-check">
                <input type="checkbox" id="es_admin" name="es_admin" class="form-check-input" 
                       <?php echo (isset($es_admin) && $es_admin) ? 'checked' : ''; ?>>
                <label for="es_admin" class="form-check-label">Usuario Administrador</label>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> Crear Usuario
            </button>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>

<script>
    // Ocultar el mensaje de éxito después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        const mensajeAlerta = document.getElementById('mensaje-alerta');
        if (mensajeAlerta) {
            setTimeout(function() {
                mensajeAlerta.style.opacity = '0';
                mensajeAlerta.style.transition = 'opacity 0.5s ease';
                setTimeout(function() {
                    mensajeAlerta.remove();
                }, 500);
            }, 5000);
        }
    });

    // Funcionalidad para mostrar/ocultar contraseña
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const confirmPassword = document.querySelector('#confirmar_password');

        if (togglePassword && password && confirmPassword) {
            togglePassword.addEventListener('click', function() {
                // Cambiar el tipo de input para ambos campos
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                confirmPassword.setAttribute('type', type);

                // Cambiar el ícono
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    });
</script>

</body>
</html> 