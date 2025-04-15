<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Eliminar Usuario - Session ID: " . session_id());
error_log("Eliminar Usuario - Session Data: " . print_r($_SESSION, true));
error_log("Eliminar Usuario - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Eliminar Usuario - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Eliminar Usuario - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Eliminar Usuario - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    $_SESSION['mensaje'] = "No se proporcionó ID de usuario";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/usuarios/ver_usuarios.php");
    exit();
}

$usuario_id = $_GET['id'];

// Verificar que no se elimine a sí mismo
if ($usuario_id == $_SESSION['usuario_id']) {
    $_SESSION['mensaje'] = "No puede eliminar su propia cuenta";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/usuarios/ver_usuarios.php");
    exit();
}

// Obtener información del usuario
try {
    // Primero obtener los datos básicos del usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        $_SESSION['mensaje'] = "Usuario no encontrado";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: " . BASE_URL . "/views/admin/usuarios/ver_usuarios.php");
        exit();
    }

    // Crear un array separado para los datos del formulario
    $datos_formulario = [
        'nombre_completo' => $usuario['nombre_completo'] ?? '',
        'nombre_usuario' => $usuario['nombre_usuario'] ?? '',
        'email' => $usuario['email'] ?? '',
        'es_admin' => $usuario['es_admin'] ?? 0,
        'total_reservas' => 0,
        'total_itinerarios' => 0
    ];

    // Luego obtener el conteo de reservas e itinerarios
    $stmt = $conn->prepare("SELECT COUNT(*) as total_reservas FROM reservas WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $reservas = $stmt->fetch(PDO::FETCH_ASSOC);
    $datos_formulario['total_reservas'] = $reservas['total_reservas'] ?? 0;

    $stmt = $conn->prepare("SELECT COUNT(*) as total_itinerarios FROM itinerarios WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $itinerarios = $stmt->fetch(PDO::FETCH_ASSOC);
    $datos_formulario['total_itinerarios'] = $itinerarios['total_itinerarios'] ?? 0;

} catch (PDOException $e) {
    error_log("Error al obtener información del usuario: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener información del usuario";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/usuarios/ver_usuarios.php");
    exit();
}

// Procesar la eliminación cuando se confirma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    try {
        // Primero eliminar las reservas asociadas
        $stmt = $conn->prepare("DELETE FROM reservas WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);

        // Luego eliminar los itinerarios asociados
        $stmt = $conn->prepare("DELETE FROM itinerarios WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);

        // Finalmente eliminar el usuario
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);

        $_SESSION['mensaje'] = "Usuario eliminado exitosamente";
        $_SESSION['tipo_mensaje'] = "success";
        header("Location: " . BASE_URL . "/views/admin/usuarios/ver_usuarios.php");
        exit();
    } catch (PDOException $e) {
        error_log("Error al eliminar el usuario: " . $e->getMessage());
        $error = "Error al eliminar el usuario. Por favor, intente nuevamente.";
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/usuarios/eliminar_usuario.css">

<main class="eliminar-usuario-container">
    <div class="eliminar-usuario-header">
        <h1>Eliminar Usuario</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/usuarios/ver_usuarios.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Usuarios
            </a>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="warning-message">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>¡Advertencia!</strong> Esta acción no se puede deshacer. Se eliminarán todas las reservas e itinerarios
        asociados a este usuario.
    </div>

    <div class="usuario-info">
        <h2>Información del Usuario</h2>
        <div class="info-group">
            <div class="info-label">Nombre Completo</div>
            <div class="info-value"><?php echo htmlspecialchars($datos_formulario['nombre_completo']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Nombre de Usuario</div>
            <div class="info-value"><?php echo htmlspecialchars($datos_formulario['nombre_usuario']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Email</div>
            <div class="info-value"><?php echo htmlspecialchars($datos_formulario['email']); ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Tipo de Usuario</div>
            <div class="info-value"><?php echo $datos_formulario['es_admin'] ? 'Administrador' : 'Usuario Normal'; ?>
            </div>
        </div>
        <div class="info-group">
            <div class="info-label">Total de Reservas</div>
            <div class="info-value"><?php echo $datos_formulario['total_reservas']; ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Total de Itinerarios</div>
            <div class="info-value"><?php echo $datos_formulario['total_itinerarios']; ?></div>
        </div>
    </div>

    <form method="POST" action="">
        <button type="submit" name="confirmar" class="btn-action btn-confirmar">
            <i class="fas fa-trash"></i> Confirmar Eliminación
        </button>
    </form>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>

</body>

</html>