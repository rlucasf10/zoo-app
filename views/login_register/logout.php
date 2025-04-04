<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Redirigir al index.php
header("Location: /zoo-app/index.php");
exit();
?>