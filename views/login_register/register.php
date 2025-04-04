<?php
session_start();
require_once __DIR__ . '/../../config/sql/database.php';
require_once __DIR__ . '/../../controllers/GoogleAuthController.php';

$mensaje = '';
$googleAuth = new GoogleAuthController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['contraseña'] ?? '';
    $confirmar_password = $_POST['confirmar_contraseña'] ?? '';

    try {
        error_log("Iniciando proceso de registro");
        error_log("Datos recibidos - Nombre: $nombre, Email: $email");

        if (empty($nombre) || empty($email) || empty($password) || empty($confirmar_password)) {
            throw new Exception('Todos los campos son obligatorios');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El correo electrónico no es válido');
        }

        if ($password !== $confirmar_password) {
            throw new Exception('Las contraseñas no coinciden');
        }

        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            throw new Exception('Este correo electrónico ya está registrado');
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $usuario_id = $conn->lastInsertId();
            error_log("Usuario registrado exitosamente. ID: $usuario_id");

            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['usuario'] = $email;
            $_SESSION['nombre'] = $nombre;
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

<main>
    <section id="register" class="register">
        <div class="container">
            <h2>Registrarse</h2>

            <?= $mensaje ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="confirmar_contraseña">Confirmar Contraseña</label>
                    <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" class="form-control"
                        required>
                </div>

                <div class="form-group d-flex justify-content-start gap-3">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                    <a href="<?php echo $googleAuth->getAuthUrl(); ?>" class="btn btn-danger">
                        Registrarse con Google
                    </a>
                </div>
            </form>
            <p>¿Ya tienes cuenta? <a href="/zoo-app/views/login_register/login.php">Inicia sesión</a></p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../plantillas/footer.php'; ?>