<?php
// Incluir archivo de configuración
require_once __DIR__ . '/../config/config.php';

// Activar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/Apache2/logs/php_errors.log');

// Función para manejar errores
function handleError($errno, $errstr, $errfile, $errline)
{
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Error interno del servidor: ' . $errstr]);
        exit;
    }
    return false;
}

// Función para manejar excepciones no capturadas
function handleException($e)
{
    error_log("Uncaught Exception: " . $e->getMessage());
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
        exit;
    }
}

// Registrar los manejadores de errores
set_error_handler('handleError');
set_exception_handler('handleException');

session_start();

// Recuperar mensaje de la sesión si existe
if (isset($_SESSION['mensaje_itinerario'])) {
    $mensaje = $_SESSION['mensaje_itinerario'];
    $tipo_mensaje = $_SESSION['tipo_mensaje_itinerario'];
    unset($_SESSION['mensaje_itinerario']);
    unset($_SESSION['tipo_mensaje_itinerario']);
}

// Verificar si es una petición POST antes de incluir cualquier otro archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    try {
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['usuario_id'])) {
            throw new Exception('Usuario no autenticado');
        }

        // Verificar que el usuario exista en la base de datos
        require_once __DIR__ . '/../config/sql/database.php';
        $checkUserQuery = "SELECT id FROM usuarios WHERE id = :usuario_id";
        $stmt = $conn->prepare($checkUserQuery);
        $stmt->bindParam(':usuario_id', $_SESSION['usuario_id']);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new Exception('Usuario no encontrado en la base de datos');
        }

        // Obtener los datos del cuerpo de la petición
        $rawData = file_get_contents('php://input');
        error_log("Datos recibidos: " . $rawData);

        if (empty($rawData)) {
            throw new Exception('No se recibieron datos');
        }

        $data = json_decode($rawData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
        }

        // Validar datos requeridos
        if (!isset($data['nombre']) || !isset($data['duracion']) || !isset($data['puntosInteres'])) {
            throw new Exception('Faltan datos requeridos');
        }

        // Incluir la conexión a la base de datos y el controlador
        require_once __DIR__ . '/../config/sql/database.php';
        require_once __DIR__ . '/../controllers/ItinerarioController.php';

        try {
            $controller = new ItinerarioController();
            $resultado = $controller->crearItinerario(
                $data['nombre'],
                $data['duracion'],
                $data['puntosInteres'],
                $_SESSION['usuario_id']
            );

            $_SESSION['mensaje_itinerario'] = "¡Itinerario creado con éxito!";
            $_SESSION['tipo_mensaje_itinerario'] = "success";
            echo json_encode(['success' => true, 'message' => "¡Itinerario creado con éxito!"]);
            exit();
        } catch (Exception $e) {
            error_log("Error al crear itinerario: " . $e->getMessage());
            $_SESSION['mensaje_itinerario'] = "Error al crear el itinerario: " . $e->getMessage();
            $_SESSION['tipo_mensaje_itinerario'] = "error";
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear el itinerario: ' . $e->getMessage()]);
            exit();
        }
    } catch (Exception $e) {
        error_log("Error en itinerarios.php: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
        $_SESSION['mensaje_itinerario'] = $e->getMessage();
        $_SESSION['tipo_mensaje_itinerario'] = "error";
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }
}

// Si no es POST, incluir el header y mostrar la página
require_once __DIR__ . '/../controllers/ItinerarioController.php';
require_once __DIR__ . '/plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/itinerarios.css">

<!-- Agregar el JavaScript específico de la página -->
<script>
    window.base_url = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL; ?>/assets/js/itinerarios.js"></script>

<main>
    <!-- Sección Hero de Itinerarios -->
    <section class="hero-itinerarios">
        <div class="hero-content">
            <h1>Planifica tu Visita</h1>
            <p>Descubre nuestras rutas predefinidas o crea tu propio itinerario personalizado</p>
        </div>
    </section>

    <!-- Sección de Itinerarios Predefinidos -->
    <section class="itinerarios-predefinidos">
        <div class="container">
            <h2>Rutas Predefinidas</h2>
            <div class="row">
                <!-- Ruta de Mamíferos -->
                <div class="col-md-4 mb-4">
                    <div class="itinerario-card">
                        <div class="itinerario-imagen">
                            <img src="<?php echo BASE_URL; ?>/assets/images/ruta-mamiferos.jpeg"
                                alt="Ruta de Mamíferos">
                            <div class="itinerario-overlay">
                                <h3>Ruta de Mamíferos</h3>
                                <p>Duración: 3 horas</p>
                            </div>
                        </div>
                        <div class="itinerario-info">
                            <h4>Ruta de Mamíferos</h4>
                            <p>Descubre los mamíferos más impresionantes de nuestro zoológico.</p>
                            <ul class="itinerario-detalles">
                                <li><i class="fas fa-clock"></i> Horario: 10:00 - 13:00</li>
                                <li><i class="fas fa-map-marker-alt"></i> Puntos de interés: 6</li>
                                <li><i class="fas fa-walking"></i> Distancia: 3 km</li>
                            </ul>
                            <button class="btn btn-itinerario" data-ruta="mamiferos">Ver Ruta</button>
                        </div>
                    </div>
                </div>

                <!-- Ruta de Aves -->
                <div class="col-md-4 mb-4">
                    <div class="itinerario-card">
                        <div class="itinerario-imagen">
                            <img src="/zoo-app/assets/images/ruta-aves.jpeg" alt="Ruta de Aves">
                            <div class="itinerario-overlay">
                                <h3>Ruta de Aves</h3>
                                <p>Duración: 2 horas</p>
                            </div>
                        </div>
                        <div class="itinerario-info">
                            <h4>Ruta de Aves</h4>
                            <p>Explora el fascinante mundo de las aves de nuestro zoológico.</p>
                            <ul class="itinerario-detalles">
                                <li><i class="fas fa-clock"></i> Horario: 11:00 - 13:00</li>
                                <li><i class="fas fa-map-marker-alt"></i> Puntos de interés: 1</li>
                                <li><i class="fas fa-walking"></i> Distancia: 2 km</li>
                            </ul>
                            <button class="btn btn-itinerario" data-ruta="aves">Ver Ruta</button>
                        </div>
                    </div>
                </div>

                <!-- Ruta Familiar -->
                <div class="col-md-4 mb-4">
                    <div class="itinerario-card">
                        <div class="itinerario-imagen">
                            <img src="/zoo-app/assets/images/ruta-familiar.jpeg" alt="Ruta Familiar">
                            <div class="itinerario-overlay">
                                <h3>Ruta Familiar</h3>
                                <p>Duración: 4 horas</p>
                            </div>
                        </div>
                        <div class="itinerario-info">
                            <h4>Ruta Familiar</h4>
                            <p>La ruta perfecta para disfrutar en familia con los más pequeños.</p>
                            <ul class="itinerario-detalles">
                                <li><i class="fas fa-clock"></i> Horario: 10:00 - 14:00</li>
                                <li><i class="fas fa-map-marker-alt"></i> Puntos de interés: 6</li>
                                <li><i class="fas fa-walking"></i> Distancia: 4 km</li>
                            </ul>
                            <button class="btn btn-itinerario" data-ruta="familiar">Ver Ruta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Crear Itinerario Personalizado -->
    <section class="itinerario-personalizado">
        <div class="container">
            <h2>Crea tu Itinerario Personalizado</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="formulario-itinerario">
                        <?php if (!isset($_SESSION['usuario_id'])): ?>
                            <div class="alert alert-info">
                                <p>Para crear un itinerario personalizado, necesitas <a
                                        href="<?php echo BASE_URL; ?>/views/login_register/login">iniciar sesión</a> o
                                    <a href="<?php echo BASE_URL; ?>/views/login_register/register">registrarte</a>.
                                </p>
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
                            <form id="formItinerario">
                                <div class="form-group">
                                    <label for="nombreItinerario">Nombre del Itinerario</label>
                                    <input type="text" class="form-control" id="nombreItinerario" name="nombreItinerario"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="duracion">Duración Estimada</label>
                                    <select class="form-control" id="duracion" name="duracion" required>
                                        <option value="1">1 hora</option>
                                        <option value="2">2 horas</option>
                                        <option value="3">3 horas</option>
                                        <option value="4">4 horas</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>
                                        Puntos de Interés *
                                        <div id="puntos-interes-container">
                                            <div class="punto-interes-item">
                                                <div class="punto-interes-content">
                                                    <select name="puntosInteres[]" class="form-control punto-interes-select"
                                                        required>
                                                        <option value="">Seleccione un punto de interés</option>
                                                        <option value="mamiferos">Mamíferos</option>
                                                        <option value="aves">Aves</option>
                                                        <option value="reptiles">Reptiles</option>
                                                        <option value="anfibios">Anfibios</option>
                                                        <option value="peces">Peces</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="btn-add-punto" class="btn-add-punto">
                                            <i class="fas fa-plus-circle"></i> Añadir Punto de Interés
                                        </button>
                                        <div class="form-text">
                                            Seleccione al menos una categoría de animales para el itinerario
                                        </div>
                                    </label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Crear Itinerario
                                    </button>
                                    <button type="button" id="btn-limpiar" class="btn btn-secondary"
                                        onclick="limpiarFormulario()">
                                        <i class="fas fa-eraser"></i> Limpiar Formulario
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vista-previa-itinerario">
                        <h3>Vista Previa del Itinerario</h3>
                        <div id="vistaPrevia" class="vista-previa-content">
                            <div class="vista-previa-itinerario-card">
                                <h4>Tu itinerario personalizado</h4>
                                <p><i class="fas fa-clock"></i> Selecciona una duración</p>
                                <div class="vista-previa-puntos">
                                    <h5>Puntos de Interés</h5>
                                    <ul>
                                        <li><i class="fas fa-map-marker-alt"></i> Selecciona puntos de interés</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Consejos -->
    <section class="consejos-itinerario">
        <div class="container">
            <h2>Consejos para tu Visita</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="consejo-card">
                        <i class="fas fa-sun"></i>
                        <h3>Mejor Momento</h3>
                        <p>Las primeras horas de la mañana son ideales para ver a los animales más activos.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="consejo-card">
                        <i class="fas fa-umbrella"></i>
                        <h3>Preparación</h3>
                        <p>Lleva agua, protector solar y ropa cómoda para disfrutar al máximo.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="consejo-card">
                        <i class="fas fa-camera"></i>
                        <h3>Fotografías</h3>
                        <p>No olvides tu cámara para capturar los momentos especiales.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>