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

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    $_SESSION['mensaje'] = "ID de animal no proporcionado";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
    exit();
}

$animal_id = $_GET['id'];

// Obtener información del animal
try {
    $stmt = $conn->prepare("
        SELECT a.*, e.nombre_especie
        FROM animales a
        LEFT JOIN especies e ON a.especie_id = e.id
        WHERE a.id = ?
    ");
    $stmt->execute([$animal_id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        $_SESSION['mensaje'] = "Animal no encontrado";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error al obtener información del animal: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener información del animal";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
    exit();
}

// Obtener todas las especies para el select
try {
    $stmt = $conn->query("SELECT id, nombre_especie FROM especies ORDER BY nombre_especie");
    $especies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener especies: " . $e->getMessage());
    $especies = [];
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar los datos de entrada
    $nombre_animal = trim($_POST['nombre_animal']);
    $especie_id = !empty($_POST['especie_id']) ? (int) $_POST['especie_id'] : null;
    $edad = !empty($_POST['edad']) ? (int) $_POST['edad'] : null;
    $categoria = trim($_POST['categoria']);
    $habitat = trim($_POST['habitat']);
    $peso = trim($_POST['peso']);
    $descripcion = trim($_POST['descripcion']);
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;

    // Inicializar la variable de errores
    $errores = [];

    // Validar campos requeridos
    if (empty($nombre_animal)) {
        $errores[] = "El nombre del animal es obligatorio";
    }
    if (empty($especie_id)) {
        $errores[] = "La especie es obligatoria";
    }
    if (empty($categoria)) {
        $errores[] = "La categoría es obligatoria";
    }
    if (empty($habitat)) {
        $errores[] = "El hábitat es obligatorio";
    }
    if (empty($peso)) {
        $errores[] = "El peso es obligatorio";
    }

    // Mantener la imagen actual por defecto
    $imagen_url = $animal['imagen_url'];

    // Procesar la nueva imagen si se ha subido una
    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == 0) {
        // Usar ruta absoluta para el directorio de destino
        $directorio_destino = __DIR__ . '/../../../assets/images/';
        $directorio_destino = str_replace('/', DIRECTORY_SEPARATOR, $directorio_destino);

        // Crear el directorio si no existe
        if (!file_exists($directorio_destino)) {
            if (!@mkdir($directorio_destino, 0755, true)) {
                $errores[] = "Error al crear el directorio de imágenes. Verifique los permisos.";
                error_log("Error al crear directorio: " . error_get_last()['message']);
            }
        }

        if (empty($errores)) {
            $archivo = $_FILES['nueva_imagen'];
            $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

            // Procesar el nombre para el archivo
            $nombre_base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $nombre_animal));
            $nombre_archivo = $nombre_base . '.' . $extension;
            $ruta_completa = $directorio_destino . $nombre_archivo;

            // Verificar si ya existe un archivo con el mismo nombre
            $contador = 1;
            while (file_exists($ruta_completa)) {
                $nombre_archivo = $nombre_base . '-' . $contador . '.' . $extension;
                $ruta_completa = $directorio_destino . $nombre_archivo;
                $contador++;
            }

            // Verificar el tipo de archivo
            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($archivo['type'], $tipos_permitidos)) {
                $errores[] = "Solo se permiten archivos de imagen (JPEG, PNG, GIF).";
                error_log("Tipo de archivo no permitido: " . $archivo['type']);
            } else {
                // Mover el archivo
                if (!@move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
                    $errores[] = "Error al subir la imagen. Verifique los permisos del directorio.";
                    error_log("Error al mover archivo: " . error_get_last()['message']);
                } else {
                    // Establecer permisos para el archivo
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        $comando = 'icacls "' . $ruta_completa . '" /grant "IUSR:(OI)(CI)(M)" /grant "IIS_IUSRS:(OI)(CI)(M)" /grant "NETWORK SERVICE:(OI)(CI)(M)"';
                        exec($comando, $output, $return_var);
                        if ($return_var !== 0) {
                            error_log("Error al establecer permisos del archivo en Windows: " . implode("\n", $output));
                        }
                    } else {
                        chmod($ruta_completa, 0644);
                    }

                    // Actualizar la ruta de la imagen
                    $imagen_url = 'assets/images/' . $nombre_archivo;
                    error_log("Nueva imagen guardada en: " . $ruta_completa);
                    error_log("Nueva URL de imagen en BD: " . $imagen_url);
                }
            }
        }
    }

    // Si no hay errores, proceder con la actualización
    if (empty($errores)) {
        try {
            // Actualizar el animal
            $stmt = $conn->prepare("
                UPDATE animales 
                SET nombre_animal = ?, 
                    especie_id = ?, 
                    edad = ?, 
                    categoria = ?, 
                    habitat = ?, 
                    peso = ?, 
                    descripcion = ?, 
                    fecha_nacimiento = ?,
                    imagen_url = ?
                WHERE id = ?
            ");

            // Log para depuración
            error_log("Ejecutando actualización con los siguientes valores:");
            error_log("nombre_animal: " . $nombre_animal);
            error_log("especie_id: " . $especie_id);
            error_log("edad: " . $edad);
            error_log("categoria: " . $categoria);
            error_log("habitat: " . $habitat);
            error_log("peso: " . $peso);
            error_log("descripcion: " . $descripcion);
            error_log("fecha_nacimiento: " . $fecha_nacimiento);
            error_log("imagen_url: " . $imagen_url);
            error_log("animal_id: " . $animal_id);

            $resultado = $stmt->execute([
                $nombre_animal,
                $especie_id,
                $edad,
                $categoria,
                $habitat,
                $peso,
                $descripcion,
                $fecha_nacimiento,
                $imagen_url,
                $animal_id
            ]);

            if ($resultado) {
                $_SESSION['mensaje'] = "Animal actualizado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
                header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
                exit();
            } else {
                $error_info = $stmt->errorInfo();
                error_log("Error en la actualización SQL: " . implode(", ", $error_info));
                $error = "Error al actualizar el animal. Detalles: " . $error_info[2];
            }
        } catch (PDOException $e) {
            error_log("Error al actualizar animal: " . $e->getMessage());
            $error = "Error al actualizar el animal. Por favor, intente nuevamente.";
        }
    } else {
        $error = implode("<br>", $errores);
    }
}

// Incluir el header
require_once __DIR__ . '/../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/animales/editar_animal.css">

<main class="editar-animal-container">
    <div class="editar-animal-header">
        <h1>Editar Animal</h1>
        <div class="header-buttons">
            <a href="<?php echo BASE_URL; ?>/views/admin/animales/ver_animales.php" class="btn-action btn-volver">
                <i class="fas fa-arrow-left"></i> Volver a Animales
            </a>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="form-container" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre_animal">Nombre del Animal</label>
            <input type="text" id="nombre_animal" name="nombre_animal"
                value="<?php echo htmlspecialchars($animal['nombre_animal'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="especie_id">Especie</label>
            <select id="especie_id" name="especie_id" required>
                <option value="">Seleccione una especie</option>
                <?php foreach ($especies as $especie): ?>
                    <option value="<?php echo $especie['id']; ?>" <?php echo ($especie['id'] == $animal['especie_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($especie['nombre_especie'] ?? ''); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="edad">Edad (años)</label>
                <input type="number" id="edad" name="edad"
                    value="<?php echo htmlspecialchars($animal['edad'] ?? ''); ?>" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <option value="mamiferos" <?php echo ($animal['categoria'] == 'mamiferos') ? 'selected' : ''; ?>>
                        Mamíferos</option>
                    <option value="aves" <?php echo ($animal['categoria'] == 'aves') ? 'selected' : ''; ?>>Aves</option>
                    <option value="reptiles" <?php echo ($animal['categoria'] == 'reptiles') ? 'selected' : ''; ?>>
                        Reptiles</option>
                    <option value="anfibios" <?php echo ($animal['categoria'] == 'anfibios') ? 'selected' : ''; ?>>
                        Anfibios</option>
                    <option value="peces" <?php echo ($animal['categoria'] == 'peces') ? 'selected' : ''; ?>>
                        Peces</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="habitat">Hábitat</label>
                <input type="text" id="habitat" name="habitat"
                    value="<?php echo htmlspecialchars($animal['habitat'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="peso">Peso (kg)</label>
                <input type="text" id="peso" name="peso" value="<?php echo htmlspecialchars($animal['peso'] ?? ''); ?>"
                    required>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion"
                rows="3"><?php echo htmlspecialchars($animal['descripcion'] ?? ''); ?></textarea>
        </div>

        <?php if (!empty($animal['imagen_url'])): ?>
            <div class="form-group">
                <label>Imagen Actual</label>
                <div class="imagen-actual">
                    <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($animal['imagen_url']); ?>"
                        alt="<?php echo htmlspecialchars($animal['nombre_animal']); ?>">
                </div>
                <input type="hidden" name="imagen_url" value="<?php echo htmlspecialchars($animal['imagen_url']); ?>">
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="nueva_imagen">Cambiar Imagen</label>
            <input type="file" id="nueva_imagen" name="nueva_imagen" class="form-control" accept="image/*">
            <div class="form-text">Formatos permitidos: JPEG, PNG, GIF</div>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                value="<?php echo htmlspecialchars($animal['fecha_nacimiento'] ?? ''); ?>">
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </form>
</main>

<?php require_once __DIR__ . '/../../plantillas/footer.php'; ?>