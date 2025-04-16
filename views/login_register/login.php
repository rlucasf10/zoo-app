<?php
require_once __DIR__ . '/../../config/config.php';
// Iniciar sesión y conectar con la base de datos
session_start();
require_once __DIR__ . '/../../config/sql/database.php';
require_once __DIR__ . '/../../controllers/GoogleAuthController.php';

$mensaje = '';
$googleAuth = new GoogleAuthController();

// Manejar el callback de Google
if (isset($_GET['code'])) {
    if (!$googleAuth->handleCallback($_GET['code'])) {
        $mensaje = '<div class="alert alert-danger">Error al iniciar sesión con Google</div>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificador = trim($_POST['identificador'] ?? '');
    $password = $_POST['contraseña'] ?? '';

    try {
        if (empty($identificador) || empty($password)) {
            throw new Exception('Todos los campos son obligatorios');
        }

        // Verificar si el identificador es un email o un nombre de usuario
        $es_email = filter_var($identificador, FILTER_VALIDATE_EMAIL);

        if ($es_email) {
            // Buscar por email
            $stmt = $conn->prepare("SELECT id, nombre_completo, nombre_usuario, password, es_admin, email FROM usuarios WHERE email = :identificador");
        } else {
            // Buscar por nombre de usuario
            $stmt = $conn->prepare("SELECT id, nombre_completo, nombre_usuario, password, es_admin, email FROM usuarios WHERE nombre_usuario = :identificador");
        }

        $stmt->bindValue(':identificador', $identificador, PDO::PARAM_STR);
        $stmt->execute();

        if ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $usuario['password'])) {
                error_log("Login - Usuario encontrado: " . print_r($usuario, true));
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['es_admin'] = $usuario['es_admin'];
                $_SESSION['email'] = $usuario['email'];
                error_log("Login - Session después de login: " . print_r($_SESSION, true));

                // Redirigir según el tipo de usuario
                if ($usuario['es_admin'] == 1) {
                    header("Location: " . BASE_URL . "/views/admin/admin_dashboard.php");
                } else {
                    header("Location: " . BASE_URL . "/views/user_dashboard.php");
                }
                exit();
            } else {
                throw new Exception('Contraseña incorrecta');
            }
        } else {
            throw new Exception('Usuario no encontrado');
        }
    } catch (Exception $e) {
        $mensaje = '<div class="alert alert-danger">' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

if (isset($_SESSION['error'])) {
    $mensaje = '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>

<?php include __DIR__ . '/../plantillas/header.php'; ?>

<main>
    <section id="login" class="login">
        <div class="container">
            <h2 class="login_register">Iniciar Sesión</h2>

            <!-- Mensajes de éxito o error -->
            <?= $mensaje ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="identificador">Correo Electrónico o Nombre de Usuario</label>
                    <input type="text" id="identificador" name="identificador" class="form-control" required
                        autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password" name="contraseña" class="form-control" required
                            autocomplete="current-password">
                        <button type="button" id="togglePassword" class="password-toggle">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <!-- Contenedor flexible para los botones -->
                <div class="form-group d-flex">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    <a href="<?php echo $googleAuth->getAuthUrl(); ?>" class="btn btn-danger">
                        Iniciar Sesión con Google
                    </a>
                </div>
            </form>
            <p>¿No tienes cuenta? <a href="<?php echo BASE_URL; ?>/views/login_register/register">Regístrate</a></p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../plantillas/footer.php'; ?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/login_register.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Cambiar el tipo de input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Cambiar el ícono
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>