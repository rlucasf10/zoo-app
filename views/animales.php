<?php
require_once __DIR__ . '/../config/config.php';
session_start();
require_once __DIR__ . '/../config/sql/database.php';

// Verificar la conexión
if (!$conn) {
    error_log("Error: No hay conexión a la base de datos");
    die("Error de conexión a la base de datos");
}

// Obtener todos los animales de la base de datos
try {
    // Primero verificar si hay datos en la tabla
    $count = $conn->query("SELECT COUNT(*) FROM animales")->fetchColumn();
    error_log("Número total de animales en la BD: " . $count);

    // Modificar la consulta para usar INNER JOIN y asegurar que solo obtenemos animales con especies válidas
    $stmt = $conn->query("
        SELECT a.*, e.nombre_especie 
        FROM animales a 
        INNER JOIN especies e ON a.especie_id = e.id 
        ORDER BY a.nombre_animal
    ");
    $animales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Número de animales obtenidos: " . count($animales));

    // Log del primer animal si existe
    if (!empty($animales)) {
        error_log("Primer animal: " . print_r($animales[0], true));
    }
} catch (PDOException $e) {
    error_log("Error al obtener animales: " . $e->getMessage());
    $animales = [];
}

require_once __DIR__ . '/plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/animales.css">

<main>
    <!-- Sección Hero de Animales -->
    <section class="hero-animales">
        <div class="hero-content">
            <h1>Nuestros Animales</h1>
            <p>Descubre la increíble diversidad de especies que habitan en nuestro zoológico</p>
        </div>
    </section>

    <!-- Filtros de Búsqueda -->
    <section class="filtros-animales">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="filtros-content">
                        <input type="text" id="buscarAnimal" class="form-control" placeholder="Buscar animal...">
                        <div class="filtros-botones">
                            <button class="btn btn-filtro active" data-filtro="todos">Todos</button>
                            <button class="btn btn-filtro" data-filtro="mamiferos">Mamíferos</button>
                            <button class="btn btn-filtro" data-filtro="aves">Aves</button>
                            <button class="btn btn-filtro" data-filtro="reptiles">Reptiles</button>
                            <button class="btn btn-filtro" data-filtro="anfibios">Anfibios</button>
                            <button class="btn btn-filtro" data-filtro="peces">Peces</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galería de Animales -->
    <section class="galeria-animales">
        <div class="container">
            <div class="row" id="animales-container">
                <?php if (empty($animales)): ?>
                    <div class="col-12 text-center">
                        <p>No hay animales registrados en este momento.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($animales as $animal): ?>
                        <div class="col-md-4 col-lg-3 mb-4 animal-card-container"
                            data-categoria="<?php echo htmlspecialchars($animal['categoria']); ?>">
                            <div class="animal-card">
                                <div class="animal-imagen">
                                    <?php if (!empty($animal['imagen_url'])): ?>
                                        <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($animal['imagen_url']); ?>"
                                            alt="<?php echo htmlspecialchars($animal['nombre_animal']); ?>">
                                    <?php else: ?>
                                        <div class="no-imagen">Sin imagen</div>
                                    <?php endif; ?>
                                    <div class="animal-overlay">
                                        <h3><?php echo htmlspecialchars($animal['nombre_animal']); ?></h3>
                                        <p class="especie"><?php echo htmlspecialchars($animal['nombre_especie']); ?></p>
                                        <p class="habitat"><?php echo htmlspecialchars($animal['habitat']); ?></p>
                                    </div>
                                </div>
                                <div class="animal-info">
                                    <h4><?php echo htmlspecialchars($animal['nombre_animal']); ?></h4>
                                    <p><?php echo htmlspecialchars($animal['descripcion']); ?></p>
                                    <div class="animal-details">
                                        <span><i class="fas fa-map-marker-alt"></i> Hábitat:
                                            <?php echo htmlspecialchars($animal['habitat']); ?></span>
                                        <span><i class="fas fa-weight"></i> Peso:
                                            <?php echo htmlspecialchars($animal['peso']); ?> kg</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Sección de Información Adicional -->
    <section class="info-animales">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-card">
                        <i class="fas fa-clock"></i>
                        <h3>Horarios de Visita</h3>
                        <p>Los mejores momentos para observar a nuestros animales son durante las horas de alimentación
                            y actividades especiales.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <i class="fas fa-map-marked-alt"></i>
                        <h3>Ubicación</h3>
                        <p>Nuestros hábitats están diseñados para replicar el entorno natural de cada especie.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <i class="fas fa-info-circle"></i>
                        <h3>Información</h3>
                        <p>Contamos con guías especializados que pueden proporcionarte información detallada sobre cada
                            animal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Agregar el JavaScript específico de la página -->
<script src="<?php echo BASE_URL; ?>/assets/js/animales.js"></script>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>