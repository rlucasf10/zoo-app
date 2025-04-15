<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Agregar logging para debug
error_log("Crear Reserva - Session ID: " . session_id());
error_log("Crear Reserva - Session Data: " . print_r($_SESSION, true));
error_log("Crear Reserva - es_admin value: " . (isset($_SESSION['es_admin']) ? ($_SESSION['es_admin'] ? 'true' : 'false') : 'not set'));

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    error_log("Crear Reserva - No usuario_id en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    error_log("Crear Reserva - No es_admin en sesión");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    error_log("Crear Reserva - Usuario no es administrador");
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Obtener lista de usuarios para el select
try {
    $stmt = $conn->query("SELECT id, nombre_completo, email FROM usuarios ORDER BY nombre_completo");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener usuarios: " . $e->getMessage());
    $usuarios = [];
}

// Obtener lista de itinerarios para el select
try {
    $stmt = $conn->query("SELECT id, nombre FROM itinerarios ORDER BY nombre");
    $itinerarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener itinerarios: " . $e->getMessage());
    $itinerarios = [];
}

// Obtener lista de animales para el select
try {
    $stmt = $conn->query("SELECT id, nombre_animal FROM animales ORDER BY nombre_animal");
    $animales = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener animales: " . $e->getMessage());
    $animales = [];
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'] ?? '';
    $itinerario_id = $_POST['itinerario_id'] ?? null;
    $animal_id = $_POST['animal_id'] ?? null;
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
                INSERT INTO reservas (
                    usuario_id, itinerario_id, animal_id, fecha_visita,
                    cantidad_personas, tipo_entrada, precio_total
                ) VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $usuario_id,
                $itinerario_id ?: null,
                $animal_id ?: null,
                $fecha_visita,
                $cantidad_personas,
                $tipo_entrada,
                $precio_total
            ]);

            $_SESSION['mensaje'] = "Reserva creada exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: " . BASE_URL . "/views/admin/reservas/ver_reservas.php");
            exit();
        } catch (PDOException $e) {
            error_log("Error al crear reserva: " . $e->getMessage());
            $errores[] = "Error al crear la reserva. Por favor, intente nuevamente.";
        }
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/reservas/crear_reserva.css">

<main class="crear-reserva-container">
    <div class="crear-reserva-header">
        <h1>Crear Nueva Reserva</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/reservas/ver_reservas.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Reservas
            </a>
        </div>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1rem;">
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="form-container">
        <div class="form-group">
            <label for="usuario_id">Usuario *</label>
            <select name="usuario_id" id="usuario_id" class="form-control" required>
                <option value="">Seleccione un usuario</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>">
                        <?php echo htmlspecialchars($usuario['nombre_completo'] . ' (' . $usuario['email'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="itinerario_id">Itinerario (opcional)</label>
            <select name="itinerario_id" id="itinerario_id" class="form-control">
                <option value="">Seleccione un itinerario</option>
                <?php foreach ($itinerarios as $itinerario): ?>
                    <option value="<?php echo $itinerario['id']; ?>">
                        <?php echo htmlspecialchars($itinerario['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="animal_id">Animal (opcional)</label>
            <select name="animal_id" id="animal_id" class="form-control">
                <option value="">Seleccione un animal</option>
                <?php foreach ($animales as $animal): ?>
                    <option value="<?php echo $animal['id']; ?>">
                        <?php echo htmlspecialchars($animal['nombre_animal']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_visita">Fecha de Visita *</label>
            <input type="date" name="fecha_visita" id="fecha_visita" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cantidad_personas">Cantidad de Personas *</label>
            <input type="number" name="cantidad_personas" id="cantidad_personas" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="tipo_entrada">Tipo de Entrada</label>
            <select name="tipo_entrada" id="tipo_entrada" class="form-control" required
                onchange="calcularPrecioTotal()">
                <option value="general">General</option>
                <option value="familiar">Familiar</option>
                <option value="vip">VIP</option>
            </select>
        </div>

        <div class="form-group">
            <label for="precio_total">Precio Total</label>
            <input type="number" name="precio_total" id="precio_total" class="form-control" step="0.01" min="0" required
                readonly>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Crear Reserva
        </button>
    </form>
</main>

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

        // Ocultar el mensaje de éxito después de 5 segundos
        const mensajeAlerta = document.querySelector('.alert-success');
        if (mensajeAlerta) {
            setTimeout(function () {
                mensajeAlerta.style.opacity = '0';
                mensajeAlerta.style.transition = 'opacity 0.5s ease';
                setTimeout(function () {
                    mensajeAlerta.remove();
                }, 500);
            }, 5000);
        }
    });
</script>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>