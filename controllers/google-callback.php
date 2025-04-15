<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/sql/database.php';
require_once __DIR__ . '/GoogleAuthController.php';

error_log("Iniciando callback de Google");
error_log("Session ID: " . session_id());
error_log("Session Data: " . print_r($_SESSION, true));

if (isset($_GET['code'])) {
    $googleAuth = new GoogleAuthController();

    if ($googleAuth->handleCallback($_GET['code'])) {
        error_log("Autenticación exitosa con Google");
        error_log("Session después de Google Auth: " . print_r($_SESSION, true));
        if ($_SESSION['es_admin']) {
            header('Location: ' . BASE_URL . '/views/admin/admin_dashboard.php');
        } else {
            header('Location: ' . BASE_URL . '/views/user_dashboard.php');
        }
        exit;
    } else {
        error_log("Error en la autenticación con Google");
        $_SESSION['error'] = 'Error al autenticar con Google. Por favor, intenta de nuevo.';
        header('Location: ' . BASE_URL . '/views/login_register/login.php');
        exit;
    }
} else {
    error_log("No se recibió el código de autorización de Google");
    $_SESSION['error'] = 'No se pudo completar la autenticación con Google.';
    header('Location: ' . BASE_URL . '/views/login_register/login.php');
    exit;
}