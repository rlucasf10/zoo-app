<?php
require_once __DIR__ . '/../../config/config.php';
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Redirigir al index.php
header("Location: " . BASE_URL . "/index.php");
exit();
?>