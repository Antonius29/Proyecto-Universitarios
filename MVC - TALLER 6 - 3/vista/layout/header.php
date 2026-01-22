<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Taller de Gestion de Alumnos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <style>

            .custom-navbar {
                padding: 1rem 2rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .navbar-brand-custom {
                font-size: 1.5rem;
                font-weight: 700;
                margin-right: 3rem;
                letter-spacing: 0.5px;
            }
            
            .nav-link-custom {
                padding: 0.5rem 1.25rem !important;
                margin: 0 0.25rem;
                border-radius: 0.375rem;
                transition: all 0.2s ease;
                font-weight: 500;
            }
            
            .nav-link-custom:hover {
                background-color: rgba(255,255,255,0.1);
            }

            .dropdown-menu-dark {
                background-color: #343a40;
                border: none;
            }

            .dropdown-menu-dark .dropdown-item {
                color: rgba(255,255,255,0.9);
                transition: all 0.2s ease;
            }

            .dropdown-menu-dark .dropdown-item:hover {
                background-color: rgba(255,255,255,0.1);
                color: #fff;
            }

            .dropdown-menu-dark .dropdown-divider {
                border-color: rgba(255,255,255,0.1);
            }
            
            .user-section {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding-left: 2rem;
                border-left: 1px solid rgba(255,255,255,0.2);
            }
            
            .user-name {
                color: rgba(255,255,255,0.9);
                font-weight: 500;
                padding: 0.5rem 1rem;
                background-color: rgba(255,255,255,0.05);
                border-radius: 0.375rem;
            }
            
            .btn-logout {
                padding: 0.5rem 1.5rem;
                border-radius: 0.375rem;
                font-weight: 500;
                transition: all 0.2s ease;
            }
            
            .btn-logout:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            }
        </style>
    </head>

    <body class= "d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
            <div class="container-fluid">

            <a class="navbar-brand navbar-brand-custom" href="index.php?accion=inicio"><i class="bi bi-backpack2"></i> SISTEMA DE ALUMNOS</a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav mr-auto">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom" href="index.php?accion=inicio"><i class="bi bi-house-door"></i> Inicio</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-link-custom dropdown-toggle" href="#" id="navbarDropdown" 
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-people"></i> Gestión de Alumnos
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="index.php?accion=nuevo">
                                        <i class="bi bi-plus-circle"></i> Registrar Alumno
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=reporte">
                                        <i class="bi bi-file-text"></i> Reporte
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                    
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <div class="user-section">
                            <span class="user-name">
                                <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                            </span>
                            <a href="index.php?accion=logout" class="btn btn-outline-light btn-logout">Cerrar Sesión</a>
                        </div>
                    <?php else: ?>
                        <div class="ml-auto">
                            <a href="index.php?accion=login" class="btn btn-outline-light btn-logout">Iniciar Sesión</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    </nav>

