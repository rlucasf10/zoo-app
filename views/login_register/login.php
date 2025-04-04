<?php
// Iniciar sesión y conectar con la base de datos
session_start();
require_once __DIR__ . '/../../config/sql/database.php';
require_once __DIR__ . '/../../controllers/GoogleAuthController.php';

$mensaje = '';
$googleAuth = new GoogleAuthController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['contraseña'] ?? '';

    try {
        if (empty($email) || empty($password)) {
            throw new Exception('Todos los campos son obligatorios');
        }

        $stmt = $conn->prepare("SELECT id, nombre, password, es_admin FROM usuarios WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $usuario['password'])) {
                error_log("Login - Usuario encontrado: " . print_r($usuario, true));
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario'] = $email;
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['es_admin'] = $usuario['es_admin'];
                error_log("Login - Session después de login: " . print_r($_SESSION, true));
                $mensaje = '<div class="alert alert-success">¡Inicio de sesión exitoso! Redirigiendo...</div>';
                echo "<script>setTimeout(() => { window.location.href = '../../index.php'; }, 2000);</script>";
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
            <h2>Iniciar Sesión</h2>

            <!-- Mensajes de éxito o error -->
            <?= $mensaje ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                </div>

                <!-- Contenedor flexible para los botones -->
                <div class="form-group d-flex justify-content-start gap-3">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    <a href="<?php echo $googleAuth->getAuthUrl(); ?>" class="btn btn-danger">
                        Iniciar Sesión con Google
                    </a>
                </div>
            </form>
            <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../plantillas/footer.php'; ?>