<?php
// Incluir el archivo del controlador y la configuración de la base de datos
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../config/sql/database.php';

// Crear una instancia del controlador con la conexión a la base de datos
$auth = new AuthController($pdo);

// Prueba de registro (crear un nuevo usuario)
echo $auth->register("Ricardo", "ricardo@example.com", "123456");

echo "<br>";

// Prueba de inicio de sesión (verificar las credenciales de un usuario registrado)
echo "<pre>";
print_r($auth->login("ricardo@example.com", "123456"));
echo "</pre>";
?>