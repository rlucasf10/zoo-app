<?php
require_once __DIR__ . '/../config/config.php';
session_start();
require_once __DIR__ . '/plantillas/header.php';
require_once __DIR__ . '/../config/sql/database.php';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: " . BASE_URL . "/views/login_register/login.php");
        exit();
    }

    try {
        // Validar datos
        if (empty($_POST['fecha_visita']) || empty($_POST['cantidad_personas'])) {
            throw new Exception("Por favor, complete todos los campos requeridos.");
        }

        $fecha_visita = $_POST['fecha_visita'];
        $cantidad_personas = (int) $_POST['cantidad_personas'];

        // Validar fecha
        $fecha_actual = new DateTime();
        $fecha_seleccionada = new DateTime($fecha_visita);
        if ($fecha_seleccionada < $fecha_actual) {
            throw new Exception("La fecha seleccionada no puede ser anterior a la fecha actual.");
        }

        // Validar cantidad de personas
        if ($cantidad_personas < 1 || $cantidad_personas > 10) {
            throw new Exception("La cantidad de personas debe estar entre 1 y 10.");
        }

        // Preparar datos
        $usuario_id = $_SESSION['usuario_id'];
        $itinerario_id = !empty($_POST['itinerario_id']) ? $_POST['itinerario_id'] : null;
        $animal_id = !empty($_POST['animal_id']) ? $_POST['animal_id'] : null;
        $tipo_entrada = $_POST['tipo_entrada'];
        $precio_total = $_POST['precio_total'];

        // Verificar conexión a la base de datos
        if (!$conn) {
            throw new Exception("Error de conexión a la base de datos.");
        }

        // Insertar la reserva
        $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, itinerario_id, animal_id, fecha_visita, cantidad_personas, tipo_entrada, precio_total) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt->execute([$usuario_id, $itinerario_id, $animal_id, $fecha_visita, $cantidad_personas, $tipo_entrada, $precio_total])) {
            throw new Exception("Error al insertar la reserva en la base de datos.");
        }

        $_SESSION['mensaje_reserva'] = "¡Reserva realizada con éxito!";
        $_SESSION['tipo_mensaje_reserva'] = "success";
        echo "<script>window.location.href = '" . BASE_URL . "/views/reservas.php';</script>";
        exit();
    } catch (Exception $e) {
        $_SESSION['mensaje_reserva'] = $e->getMessage();
        $_SESSION['tipo_mensaje_reserva'] = "error";
        error_log("Error en reserva: " . $e->getMessage());
    }
}

// Recuperar mensaje de la sesión si existe
if (isset($_SESSION['mensaje_reserva'])) {
    $mensaje = $_SESSION['mensaje_reserva'];
    $tipo_mensaje = $_SESSION['tipo_mensaje_reserva'];
    unset($_SESSION['mensaje_reserva']);
    unset($_SESSION['tipo_mensaje_reserva']);
}

// Obtener itinerarios disponibles
try {
    $stmt = $conn->query("SELECT * FROM itinerarios");
    $itinerarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener itinerarios: " . $e->getMessage());
    $itinerarios = [];
}

// Obtener animales disponibles
try {
    $check = $conn->query("SELECT COUNT(*) as total FROM animales");
    $total = $check->fetch(PDO::FETCH_ASSOC)['total'];
    error_log("Total de animales en la base de datos: " . $total);

    $stmt = $conn->query("
        SELECT 
            a.id,
            a.nombre_animal,
            e.nombre_especie,
            a.descripcion,
            a.imagen_url
        FROM animales a 
        LEFT JOIN especies e ON a.especie_id = e.id 
        ORDER BY a.nombre_animal ASC
    ");
    $animales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("Animales obtenidos: " . print_r($animales, true));
} catch (PDOException $e) {
    error_log("Error al obtener animales: " . $e->getMessage());
    $animales = [];
}
?>

<!-- Agregar el CSS específico de la página -->
<style>
    :root {
        --base-url:
            <?php echo BASE_URL; ?>
        ;
    }
</style>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/reservas.css">

<main class="reservas-container">
    <!-- Sección Hero -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Reserva tu Visita al Zoo</h1>
            <p>Una experiencia única te espera</p>
        </div>
    </section>

    <!-- Sección de Precios -->
    <section class="precios-section">
        <div class="container">
            <h2 class="text-center mb-4">Nuestros Precios</h2>
            <div class="precios-grid">
                <div class="precio-card">
                    <h3>Entrada General</h3>
                    <div class="precio">€15</div>
                    <ul>
                        <li>Acceso a todas las instalaciones</li>
                        <li>Guía turístico incluido</li>
                        <li>Duración: 4 horas</li>
                    </ul>
                    <button class="btn btn-primary" onclick="seleccionarTipo('general')">Seleccionar</button>
                </div>
                <div class="precio-card">
                    <h3>Entrada Familiar</h3>
                    <div class="precio">€45</div>
                    <ul>
                        <li>4 entradas generales</li>
                        <li>Actividades especiales</li>
                        <li>Duración: 6 horas</li>
                    </ul>
                    <button class="btn btn-primary" onclick="seleccionarTipo('familiar')">Seleccionar</button>
                </div>
                <div class="precio-card">
                    <h3>Entrada VIP</h3>
                    <div class="precio">€25</div>
                    <ul>
                        <li>Acceso prioritario</li>
                        <li>Tour guiado privado</li>
                        <li>Duración: 8 horas</li>
                    </ul>
                    <button class="btn btn-primary" onclick="seleccionarTipo('vip')">Seleccionar</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario de Reserva -->
    <section class="container">
        <div class="formulario-reserva">
            <h2>Completa tu Reserva</h2>

            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <div class="alert alert-info">
                    <p>Para crear una reserva, necesitas <a
                            href="<?php echo BASE_URL; ?>/views/login_register/login.php">iniciar sesión</a> o <a
                            href="<?php echo BASE_URL; ?>/views/login_register/registro.php">registrarte</a>.</p>
                </div>
            <?php else: ?>
                <?php if (isset($mensaje)): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje === 'success' ? 'success' : 'danger'; ?>"
                        id="mensaje-alerta">
                        <?php echo $mensaje; ?>
                    </div>
                    <?php if ($tipo_mensaje === 'success'): ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                setTimeout(function () {
                                    var mensajeAlerta = document.getElementById('mensaje-alerta');
                                    if (mensajeAlerta) {
                                        mensajeAlerta.style.opacity = '0';
                                        mensajeAlerta.style.transition = 'opacity 0.5s ease';
                                        setTimeout(function () {
                                            mensajeAlerta.remove();
                                        }, 500);
                                    }
                                }, 5000);
                            });
                        </script>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="POST" action="" id="formularioReserva">
                    <input type="hidden" name="tipo_entrada" id="tipo_entrada">
                    <input type="hidden" name="precio_total" id="precio_total">
                    <div class="form-group">
                        <label for="fecha_visita">Fecha de Visita</label>
                        <input type="date" class="form-control" id="fecha_visita" name="fecha_visita" required
                            min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="cantidad_personas">Número de Personas</label>
                        <input type="number" class="form-control" id="cantidad_personas" name="cantidad_personas" required
                            min="1" max="10">
                    </div>

                    <div class="form-group">
                        <label for="itinerario_id">Itinerario (Opcional)</label>
                        <select class="form-control" id="itinerario_id" name="itinerario_id">
                            <option value="">Selecciona un itinerario</option>
                            <?php foreach ($itinerarios as $itinerario): ?>
                                <option value="<?php echo $itinerario['id']; ?>">
                                    <?php echo htmlspecialchars($itinerario['nombre']); ?> -
                                    <?php echo $itinerario['duracion']; ?> horas
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="animal_id">Animal Favorito (Opcional)</label>
                        <select class="form-control" id="animal_id" name="animal_id">
                            <option value="">Selecciona un animal</option>
                            <?php if (!empty($animales)): ?>
                                <?php foreach ($animales as $animal): ?>
                                    <option value="<?php echo htmlspecialchars($animal['id']); ?>">
                                        <?php echo htmlspecialchars($animal['nombre_animal']); ?> -
                                        <?php echo htmlspecialchars($animal['nombre_especie'] ?? 'Sin especie'); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No hay animales disponibles</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Resumen de la Reserva -->
                    <div class="resumen-reserva">
                        <h3>Resumen de la Reserva</h3>
                        <div class="resumen-item">
                            <span>Entrada:</span>
                            <span id="tipoEntrada">-</span>
                        </div>
                        <div class="resumen-item">
                            <span>Precio por persona:</span>
                            <span id="precioPersona">-</span>
                        </div>
                        <div class="resumen-item">
                            <span>Número de personas:</span>
                            <span id="numPersonas">-</span>
                        </div>
                        <div class="resumen-total">
                            <span>Total:</span>
                            <span id="total">-</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-reservar">Confirmar Reserva</button>
                </form>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
    let tipoSeleccionado = '';
    let precioBase = 0;

    function seleccionarTipo(tipo) {
        tipoSeleccionado = tipo;
        switch (tipo) {
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
        document.getElementById('tipo_entrada').value = tipo;
        actualizarResumen();
    }

    function actualizarResumen() {
        const cantidadPersonas = parseInt(document.getElementById('cantidad_personas').value) || 0;
        const tipoEntradaMap = {
            'general': 'Entrada General',
            'familiar': 'Entrada Familiar',
            'vip': 'Entrada VIP'
        };

        document.getElementById('tipoEntrada').textContent = tipoEntradaMap[tipoSeleccionado] || '-';
        document.getElementById('precioPersona').textContent = precioBase ? `€${precioBase}` : '-';
        document.getElementById('numPersonas').textContent = cantidadPersonas || '-';

        const total = precioBase && cantidadPersonas ? precioBase * cantidadPersonas : 0;
        document.getElementById('total').textContent = total ? `€${total}` : '-';
        document.getElementById('precio_total').value = total;
    }

    // Esperar a que el DOM esté cargado
    document.addEventListener('DOMContentLoaded', function () {
        const cantidadPersonasInput = document.getElementById('cantidad_personas');
        if (cantidadPersonasInput) {
            cantidadPersonasInput.addEventListener('input', actualizarResumen);
        }
    });
</script>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>