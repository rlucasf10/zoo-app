<?php
require_once __DIR__ . '/../../../config/config.php';
session_start();

// Incluir el archivo de configuración de la base de datos
require_once '../../../config/sql/database.php';

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

// Obtener lista de especies para el selector
try {
    $stmt = $conn->prepare("SELECT id, nombre_especie FROM especies ORDER BY nombre_especie");
    $stmt->execute();
    $especies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener lista de especies: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener lista de especies";
    $_SESSION['tipo_mensaje'] = "danger";
}

// Obtener lista de itinerarios para el selector
try {
    $stmt = $conn->prepare("SELECT id, nombre FROM itinerarios ORDER BY nombre");
    $stmt->execute();
    $itinerarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener lista de itinerarios: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al obtener lista de itinerarios";
    $_SESSION['tipo_mensaje'] = "danger";
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar datos
    $nombre_animal = trim($_POST['nombre_animal']);
    $edad = !empty($_POST['edad']) ? (int) $_POST['edad'] : null;
    $especie_id = isset($_POST['especie_id']) ? (int) $_POST['especie_id'] : null;
    $itinerario_id = !empty($_POST['itinerario_id']) ? (int) $_POST['itinerario_id'] : null;
    $habitat = trim($_POST['habitat']);
    $peso = trim($_POST['peso']);
    $categoria = $_POST['categoria'];
    $descripcion = trim($_POST['descripcion']);
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;

    // Procesar la imagen
    $imagen_url = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Usar ruta absoluta para el directorio de destino
        $directorio_destino = __DIR__ . '/../../../assets/images/';

        // Asegurarse de que la ruta use separadores de directorio correctos para Windows
        $directorio_destino = str_replace('/', DIRECTORY_SEPARATOR, $directorio_destino);

        // Crear el directorio si no existe
        if (!file_exists($directorio_destino)) {
            if (!@mkdir($directorio_destino, 0755, true)) {
                $errores[] = "Error al crear el directorio de imágenes. Verifique los permisos.";
                error_log("Error al crear directorio: " . error_get_last()['message']);
            }
        } else {
            // Asegurarse de que el directorio tenga los permisos correctos
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // En Windows, usar icacls para establecer permisos
                $comando = 'icacls "' . $directorio_destino . '" /grant "Users:(OI)(CI)(F)" /grant "Todos:(OI)(CI)(F)"';
                exec($comando, $output, $return_var);
                if ($return_var !== 0) {
                    error_log("Error al establecer permisos en Windows: " . implode("\n", $output));
                }
            } else {
                // En Linux/Unix, usar chmod
                chmod($directorio_destino, 0755);
            }
        }

        if (empty($errores)) {
            $archivo = $_FILES['imagen'];
            $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

            // Procesar el nombre para el archivo: eliminar palabras como "de", "del", "la", "las", etc.
            $palabras_a_eliminar = ['de', 'del', 'la', 'las', 'los', 'el', 'en', 'por', 'para', 'con', 'sin'];
            $palabras = explode(' ', strtolower($nombre_animal));
            $palabras_filtradas = array_filter($palabras, function ($palabra) use ($palabras_a_eliminar) {
                return !in_array($palabra, $palabras_a_eliminar);
            });
            $nombre_base = implode('-', $palabras_filtradas);

            $nombre_archivo = $nombre_base . '.' . $extension;
            $ruta_completa = $directorio_destino . $nombre_archivo;

            // Verificar si ya existe un archivo con el mismo nombre
            $contador = 1;
            while (file_exists($ruta_completa)) {
                // Si existe, agregar un número al final
                $nombre_archivo = $nombre_base . '-' . $contador . '.' . $extension;
                $ruta_completa = $directorio_destino . $nombre_archivo;
                $contador++;
            }

            // Verificar el tipo de archivo
            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($archivo['type'], $tipos_permitidos)) {
                $errores[] = "Solo se permiten archivos de imagen (JPEG, PNG, GIF). Tipo recibido: " . $archivo['type'];
                error_log("Tipo de archivo no permitido: " . $archivo['type']);
            } else {
                // Mover el archivo
                if (!@move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
                    $errores[] = "Error al subir la imagen. Verifique los permisos del directorio.";
                    error_log("Error al mover archivo: " . error_get_last()['message']);
                } else {
                    // Establecer permisos para que Git pueda acceder al archivo
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        // En Windows, usar icacls para establecer permisos
                        $comando = 'icacls "' . $ruta_completa . '" /grant "Usuarios:(F)" /grant "Todos:(F)" /T';
                        exec($comando, $output, $return_var);
                        if ($return_var !== 0) {
                            error_log("Error al establecer permisos del archivo en Windows: " . implode("\n", $output));
                        }
                    } else {
                        // En Linux/Unix, usar chmod
                        chmod($ruta_completa, 0644);
                    }

                    // Guardar la ruta relativa en la base de datos
                    $imagen_url = '/assets/images/' . $nombre_archivo;
                    error_log("Imagen guardada en: " . $ruta_completa);
                    error_log("URL de imagen en BD: " . $imagen_url);
                }
            }
        }
    }

    // Validar campos requeridos
    if (empty($nombre_animal)) {
        $errores[] = "El nombre del animal es obligatorio";
    }
    if (empty($especie_id)) {
        $errores[] = "La especie es obligatoria";
    }
    if (empty($habitat)) {
        $errores[] = "El hábitat es obligatorio";
    }
    if (empty($peso)) {
        $errores[] = "El peso es obligatorio";
    }
    if (empty($categoria)) {
        $errores[] = "La categoría es obligatoria";
    }
    if (empty($imagen_url)) {
        $errores[] = "La imagen es obligatoria";
    }

    // Si no hay errores, insertar en la base de datos
    if (empty($errores)) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO animales (
                    nombre_animal, edad, especie_id, itinerario_id, 
                    habitat, peso, categoria, imagen_url, descripcion, fecha_nacimiento
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            if (
                !$stmt->execute([
                    $nombre_animal,
                    $edad,
                    $especie_id,
                    $itinerario_id,
                    $habitat,
                    $peso,
                    $categoria,
                    $imagen_url,
                    $descripcion,
                    $fecha_nacimiento
                ])
            ) {
                $error_info = $stmt->errorInfo();
                error_log("Error SQL: " . implode(", ", $error_info));
                throw new Exception("Error en la base de datos: " . $error_info[2]);
            }

            $_SESSION['mensaje'] = "Animal creado correctamente";
            $_SESSION['tipo_mensaje'] = "success";

            // Redirigir a la lista de animales
            header("Location: " . BASE_URL . "/views/admin/animales/ver_animales.php");
            exit();
        } catch (Exception $e) {
            error_log("Error al crear animal: " . $e->getMessage());
            $errores[] = "Error al crear el animal: " . $e->getMessage();
        }
    } else {
        // No redirigir, solo establecer los mensajes de error
        // Los errores ya están en la variable $errores y se mostrarán en la página
    }
}

// Incluir el header
require_once '../../plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin/animales/crear_animal.css">

<main class="crear-animal-container">
    <div class="crear-animal-header">
        <h1>Crear Nuevo Animal</h1>
        <a href="<?php echo BASE_URL; ?>/views/admin/animales/ver_animales.php" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver a Animales
        </a>
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

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" class="form-container">
        <div class="form-group">
            <label for="nombre_animal">Nombre del Animal *</label>
            <input type="text" id="nombre_animal" name="nombre_animal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="especie_id">Especie *</label>
            <select id="especie_id" name="especie_id" class="form-control" required>
                <option value="">Seleccione una especie</option>
                <?php foreach ($especies as $especie): ?>
                    <option value="<?php echo $especie['id']; ?>">
                        <?php echo htmlspecialchars($especie['nombre_especie']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="edad">Edad (años)</label>
            <input type="number" id="edad" name="edad" class="form-control" min="0">
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">
        </div>

        <div class="form-group">
            <label for="habitat">Hábitat *</label>
            <input type="text" id="habitat" name="habitat" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="peso">Peso (kg) *</label>
            <input type="text" id="peso" name="peso" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoría *</label>
            <select id="categoria" name="categoria" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                <option value="mamiferos">Mamíferos</option>
                <option value="aves">Aves</option>
                <option value="reptiles">Reptiles</option>
                <option value="anfibios">Anfibios</option>
                <option value="peces">Peces</option>
            </select>
        </div>

        <div class="form-group">
            <label for="itinerario_id">Itinerario Asignado</label>
            <select id="itinerario_id" name="itinerario_id" class="form-control">
                <option value="">Seleccione un itinerario (opcional)</option>
                <?php foreach ($itinerarios as $itinerario): ?>
                    <option value="<?php echo $itinerario['id']; ?>">
                        <?php echo htmlspecialchars($itinerario['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="imagen">Imagen *</label>
            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" required>
            <div class="form-text">Formatos permitidos: JPEG, PNG, GIF</div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Crear Animal
        </button>
    </form>
</main>

<?php require_once '../../plantillas/footer.php'; ?>