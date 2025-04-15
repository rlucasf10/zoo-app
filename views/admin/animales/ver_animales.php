<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if (!isset($_SESSION['es_admin'])) {
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

if ($_SESSION['es_admin'] !== true && $_SESSION['es_admin'] !== 1) {
    header("Location: " . BASE_URL . "/views/login_register/login.php");
    exit();
}

require_once __DIR__ . '/../../../config/sql/database.php';

// Obtener lista de animales con información de especies
try {
    $stmt = $conn->prepare("
        SELECT a.*, e.nombre_especie
        FROM animales a
        LEFT JOIN especies e ON a.especie_id = e.id
        ORDER BY a.nombre_animal
    ");
    $stmt->execute();
    $animales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Agregar log para verificar la cantidad de registros
    error_log("Total de animales obtenidos: " . count($animales));

    // Verificar si hay algún error en la consulta
    if ($stmt->errorCode() !== '00000') {
        error_log("Error en la consulta SQL: " . implode(", ", $stmt->errorInfo()));
    }

    // Log para depurar las rutas de imágenes
    foreach ($animales as $animal) {
        error_log("Animal ID: " . $animal['id'] . ", Nombre: " . $animal['nombre_animal'] . ", URL imagen: " . $animal['imagen_url']);
    }
} catch (PDOException $e) {
    error_log("Error al obtener lista de animales: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener lista de animales";
    $_SESSION['tipo_mensaje'] = "danger";
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/animales/ver_animales.css">


<main class="ver-animales-container">
    <div class="ver-animales-header">
        <h1>Gestión de Animales</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/animales/crear_animal.php" class="btn-action btn-crear">
                <i class="fas fa-plus"></i> Crear Nuevo Animal
            </a>
            <a href="<?php echo BASE_URL; ?>/views/admin/admin_dashboard.php" class="btn-action btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        </div>
    <?php endif; ?>

    <div class="tabla-container">
        <?php if (empty($animales)): ?>
            <div class="no-animales">
                <i class="fas fa-paw"></i>
                <p>No hay animales registrados</p>
            </div>
        <?php else: ?>
            <table class="tabla-animales">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Especie</th>
                        <th>Edad</th>
                        <th>Categoría</th>
                        <th>Hábitat</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($animales as $animal): ?>
                        <tr>
                            <td><?php echo $animal['id']; ?></td>
                            <td>
                                <?php if (!empty($animal['imagen_url'])): ?>
                                    <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($animal['imagen_url']); ?>"
                                        alt="<?php echo htmlspecialchars($animal['nombre_animal']); ?>" class="imagen-miniatura">
                                <?php else: ?>
                                    <div class="no-imagen">Sin imagen</div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($animal['nombre_animal']); ?></td>
                            <td><?php echo htmlspecialchars($animal['nombre_especie'] ?? 'Sin especie'); ?></td>
                            <td><?php echo $animal['edad'] ? $animal['edad'] . ' años' : 'No especificado'; ?></td>
                            <td><?php echo ucfirst($animal['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($animal['habitat']); ?></td>
                            <td class="acciones">
                                <a href="<?php echo BASE_URL; ?>/views/admin/animales/editar_animal.php?id=<?php echo $animal['id']; ?>"
                                    class="btn-action btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/views/admin/animales/eliminar_animal.php?id=<?php echo $animal['id']; ?>"
                                    class="btn-action btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<script>
    // Ocultar el mensaje de éxito después de 5 segundos
    document.addEventListener('DOMContentLoaded', function () {
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