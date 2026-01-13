<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    session_start();

    require_once __DIR__ . '/controlador/LoginControlador.php';
    $loginCTRL = new LoginControlador();

    $accion = $_GET['accion'] ?? 'default';

    switch ($accion) {
            case 'login':

                $loginCTRL->login();
                break;
                
            case 'inicio':

                // Lógica para verificar si el usuario está realmente logueado
                if (!isset($_SESSION['usuario'])) {
                    header("Location: index.php?accion=login");
                    exit;
                }
                // Cargar las vistas de inicio
                require_once __DIR__ . '/vista/layout/header.php';
                echo'<div class = "container mt-5"> <h2 class ="text-center" style="color:#1e3557"> <b> BIENVENIDO AL SISTEMA DE ALUMNO </h2> </b> </div>' ;
                require_once __DIR__ . '/vista/layout/footer.php'; 
                break;

            default:
            $loginCTRL->mostrarFormulario();
            break;
        }
    ?>
