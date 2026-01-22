<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Century Gothic', sans-serif;
            background-color: #dbdbdb;
        }

        .container-login {
            max-width: 400px;
        }

    </style>
</head>

<?php
// Iniciamos la sesión al principio de todo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargamos los controladores una sola vez
require_once __DIR__ . '/controlador/LoginControlador.php';
require_once __DIR__ . '/controlador/AlumnoControlador.php';

// Creamos los objetos (instancias) de los controladores
$loginCtrl = new LoginControlador();
$alumnoCtrl = new AlumnoControlador();

// Capturamos la acción de la URL, por defecto será 'login'
$accion = $_GET['accion'] ?? 'login';

switch ($accion) {
    case 'login':
        $loginCtrl->login();
        break;

    case 'logout':
        $loginCtrl->logout();
        break;

    case 'listar':
    case 'reporte': // Ambas acciones mostrarán la lista de alumnos
        // Verificamos si el usuario está logueado
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }
        // Llamamos al método listar (que ya no es estático)
        $alumnoCtrl->listar();
        break;

    case 'nuevo':
        // Mostrar formulario para crear nuevo alumno
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }
        $alumnoCtrl->formulario();
        break;

    case 'guardar':
        // Guardar alumno
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }
        $alumnoCtrl->guardar();
        break;

    case 'inicio':
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }
        require_once 'vista/layout/header.php';
        echo '<div class="container mt-5"><h2 class="text-center">Bienvenido al Sistema de Alumnos</h2></div>';
        require_once 'vista/layout/footer.php';
        break;

    default:
        // Si la acción no existe, mostramos el formulario de login
        $loginCtrl->mostrarFormulario();
        break;
}