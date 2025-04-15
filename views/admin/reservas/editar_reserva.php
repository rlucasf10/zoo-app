<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Editar Reserva - Session ID: " . session_id());
error_log("Editar Reserva - Session Data: " . print_r($_SESSION, true));
error_log("Editar Reserva - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Editar Reserva - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Editar Reserva - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Editar Reserva - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    $_SESSION['mensaje'] = "No se proporcionó ID de reserva";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ver_reservas.php");
    exit();
}

$reserva_id = $_GET['id'];

// Obtener información de la reserva
try {
    $stmt = $conn->prepare("
        SELECT r.*, 
               u.nombre_completo as nombre_usuario,
               i.nombre as nombre_itinerario,
               a.nombre_animal
        FROM reservas r
        JOIN usuarios u ON r.usuario_id = u.id
        LEFT JOIN itinerarios i ON r.itinerario_id = i.id
        LEFT JOIN animales a ON r.animal_id = a.id
        WHERE r.id = ?
    ");
    $stmt->execute([$reserva_id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        $_SESSION['mensaje'] = "Reserva no encontrada";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: ver_reservas.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error al obtener información de la reserva: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener información de la reserva";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ver_reservas.php");
    exit();
}

// Obtener listas para los selectores
try {
    // Obtener usuarios
    $stmt = $conn->query("SELECT id, nombre_completo, email FROM usuarios ORDER BY nombre_completo");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener itinerarios
    $stmt = $conn->query("SELECT id, nombre FROM itinerarios ORDER BY nombre");
    $itinerarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener animales
    $stmt = $conn->query("SELECT id, nombre_animal FROM animales ORDER BY nombre_animal");
    $animales = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener datos para los selectores: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al cargar los datos necesarios";
    $_SESSION['tipo_mensaje'] = "danger";
    $usuarios = [];
    $itinerarios = [];
    $animales = [];
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'] ?? '';
    $itinerario_id = $_POST['itinerario_id'] ?? '';
    $animal_id = $_POST['animal_id'] ?? '';
    $fecha_visita = $_POST['fecha_visita'] ?? '';
    $cantidad_personas = $_POST['cantidad_personas'] ?? '';
    $tipo_entrada = $_POST['tipo_entrada'] ?? '';
    $precio_total = $_POST['precio_total'] ?? '';

    // Validaciones
    $errores = [];
    if (empty($usuario_id))
        $errores[] = "El usuario es obligatorio";
    if (empty($fecha_visita))
        $errores[] = "La fecha de visita es obligatoria";
    if (empty($cantidad_personas))
        $errores[] = "La cantidad de personas es obligatoria";
    if (empty($tipo_entrada))
        $errores[] = "El tipo de entrada es obligatorio";
    if (empty($precio_total))
        $errores[] = "El precio total es obligatorio";

    if (empty($errores)) {
        try {
            $stmt = $conn->prepare("
                UPDATE reservas 
                SET usuario_id = ?,
                    itinerario_id = ?,
                    animal_id = ?,
                    fecha_visita = ?,
                    cantidad_personas = ?,
                    tipo_entrada = ?,
                    precio_total = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $usuario_id,
                $itinerario_id ?: null,
                $animal_id ?: null,
                $fecha_visita,
                $cantidad_personas,
                $tipo_entrada,
                $precio_total,
                $reserva_id
            ]);

            $_SESSION['mensaje'] = "Reserva actualizada exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: " . BASE_URL . "/views/admin/reservas/ver_reservas.php");
            exit();
        } catch (PDOException $e) {
            error_log("Error al actualizar la reserva: " . $e->getMessage());
            $errores[] = "Error al actualizar la reserva. Por favor, intente nuevamente.";
        }
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/reservas/editar_reserva.css">

<div class="editar-reserva-container">
    <div class="editar-reserva-header">
        <h1>Editar Reserva</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/reservas/ver_reservas.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Reservas
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <?php echo implode('<br>', $errores); ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="usuario_id">Usuario</label>
                <select name="usuario_id" id="usuario_id" class="form-control" required>
                    <option value="">Seleccione un usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id']; ?>" <?php echo ($reserva['usuario_id'] == $usuario['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($usuario['nombre_completo']); ?>
                            (<?php echo htmlspecialchars($usuario['email']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="itinerario_id">Itinerario</label>
                <select name="itinerario_id" id="itinerario_id" class="form-control">
                    <option value="">Seleccione un itinerario (opcional)</option>
                    <?php foreach ($itinerarios as $itinerario): ?>
                        <option value="<?php echo $itinerario['id']; ?>" <?php echo ($reserva['itinerario_id'] == $itinerario['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($itinerario['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="animal_id">Animal</label>
                <select name="animal_id" id="animal_id" class="form-control">
                    <option value="">Seleccione un animal (opcional)</option>
                    <?php foreach ($animales as $animal): ?>
                        <option value="<?php echo $animal['id']; ?>" <?php echo ($reserva['animal_id'] == $animal['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($animal['nombre_animal']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_visita">Fecha de Visita</label>
                <input type="date" id="fecha_visita" name="fecha_visita" class="form-control"
                    value="<?php echo htmlspecialchars($reserva['fecha_visita']); ?>" required>
            </div>

            <div class="form-group">
                <label for="cantidad_personas">Cantidad de Personas</label>
                <input type="number" id="cantidad_personas" name="cantidad_personas" class="form-control"
                    value="<?php echo htmlspecialchars($reserva['cantidad_personas']); ?>" required min="1">
            </div>

            <div class="form-group">
                <label for="tipo_entrada">Tipo de Entrada</label>
                <select name="tipo_entrada" id="tipo_entrada" class="form-control" required>
                    <option value="">Seleccione un tipo de entrada</option>
                    <option value="general" <?php echo ($reserva['tipo_entrada'] == 'general') ? 'selected' : ''; ?>>
                        General</option>
                    <option value="familiar" <?php echo ($reserva['tipo_entrada'] == 'familiar') ? 'selected' : ''; ?>>
                        Familiar</option>
                    <option value="vip" <?php echo ($reserva['tipo_entrada'] == 'vip') ? 'selected' : ''; ?>>VIP</option>
                </select>
            </div>

            <div class="form-group">
                <label for="precio_total">Precio Total</label>
                <input type="number" id="precio_total" name="precio_total" class="form-control"
                    value="<?php echo htmlspecialchars($reserva['precio_total']); ?>" required min="0" step="0.01">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function calcularPrecioTotal() {
        const tipoEntrada = document.getElementById('tipo_entrada').value;
        const numPersonas = document.getElementById('cantidad_personas').value;
        let precioBase = 0;

        // Definir precios base según tipo de entrada
        switch (tipoEntrada) {
            case 'general':
                precioBase = 15;
                break;
            case 'familiar':
                precioBase = 45;
                break;
            case 'vip':
                precioBase = 25;
                break;
        }

        // Calcular precio total
        const precioTotal = precioBase * numPersonas;
        document.getElementById('precio_total').value = precioTotal;
    }

    // Calcular precio inicial al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        calcularPrecioTotal();

        // Agregar evento para recalcular cuando cambie el número de personas
        document.getElementById('cantidad_personas').addEventListener('change', calcularPrecioTotal);
    });

</script>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>