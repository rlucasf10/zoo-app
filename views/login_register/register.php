<?php
require_once __DIR__ . '/../../config/config.php';
session_start();
require_once __DIR__ . '/../../config/sql/database.php';
require_once __DIR__ . '/../../controllers/GoogleAuthController.php';

$mensaje = '';
$googleAuth = new GoogleAuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_completo = trim($_POST['nombre_completo'] ?? '');
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['contraseña'] ?? '';
    $confirmar_password = $_POST['confirmar_contraseña'] ?? '';

    try {
        error_log("Iniciando proceso de registro");
        error_log("Datos recibidos - Nombre completo: $nombre_completo, Nombre de usuario: $nombre_usuario, Email: $email");

        if (empty($nombre_completo) || empty($nombre_usuario) || empty($email) || empty($password) || empty($confirmar_password)) {
            throw new Exception('Todos los campos son obligatorios');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El correo electrónico no es válido');
        }

        if ($password !== $confirmar_password) {
            throw new Exception('Las contraseñas no coinciden');
        }

        // Verificar si el email ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            throw new Exception('Este correo electrónico ya está registrado');
        }

        // Verificar si el nombre de usuario ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario = :nombre_usuario");
        $stmt->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            throw new Exception('Este nombre de usuario ya está en uso');
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, nombre_usuario, email, password) VALUES (:nombre_completo, :nombre_usuario, :email, :password)");
        $stmt->bindValue(':nombre_completo', $nombre_completo, PDO::PARAM_STR);
        $stmt->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $usuario_id = $conn->lastInsertId();
            error_log("Usuario registrado exitosamente. ID: $usuario_id");

            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['usuario'] = $email;
            $_SESSION['nombre_completo'] = $nombre_completo;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['es_admin'] = false;

            $mensaje = '<div class="alert alert-success">¡Registro exitoso! Redirigiendo...</div>';
            echo "<script>setTimeout(() => { window.location.href = '/zoo-app/index.php'; }, 2000);</script>";
        } else {
            error_log("Error al ejecutar la inserción en la base de datos");
            throw new Exception('Error al registrar el usuario. Intente nuevamente.');
        }
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage());
        $mensaje = '<div class="alert alert-danger">Error al conectar con la base de datos. Por favor, intente más tarde.</div>';
    } catch (Exception $e) {
        error_log("Error en el registro: " . $e->getMessage());
        $mensaje = '<div class="alert alert-danger">' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

if (isset($_SESSION['error'])) {
    $mensaje = '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>

<?php include __DIR__ . '/../plantillas/header.php'; ?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/login_register.css">

<main>
    <section id="register" class="login">
        <div class="container">
            <h2 class="login_register">Registrarse</h2>

            <?= $mensaje ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="nombre_completo">Nombre Completo</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required
                        autocomplete="name">
                </div>

                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" required
                        autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password" name="contraseña" class="form-control" required
                            autocomplete="new-password">
                        <button type="button" id="togglePassword" class="password-toggle">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" id="confirm_password" name="confirmar_contraseña" class="form-control"
                        required autocomplete="new-password">
                </div>

                <div class="form-group d-flex justify-content-start gap-3">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
            <p>¿Ya tienes cuenta? <a href="<?php echo BASE_URL; ?>/views/login_register/login.php">Inicia sesión</a>
            </p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../plantillas/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const confirmPassword = document.querySelector('#confirm_password');

        togglePassword.addEventListener('click', function () {
            // Cambiar el tipo de input para ambos campos
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            confirmPassword.setAttribute('type', type);

            // Cambiar el ícono
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>