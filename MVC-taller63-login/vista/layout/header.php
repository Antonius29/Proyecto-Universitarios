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
                padding: 16px 32px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .navbar-brand-custom {
                font-size: 24px;
                font-weight: 700;
                letter-spacing: 0.5px;
            }
            
            .nav-link-custom {
                padding: 8px 16px;
                margin: 0 2.4px;
                border-radius: 6px;
                transition: all 0.2s ease;
                font-weight: 500;
            }
            
            .nav-link-custom:hover {
                background-color: rgba(255,255,255,0.1);
            }

            .dropdown-menu {
                background-color: #343a40;
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 6px;
                margin-top: 8px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            }
            
            .dropdown-item {
                color: rgba(255,255,255,0.9);
                padding: 12px 14px;
                font-weight: 500;
                transition: all 0.2s ease;
            }
            
            .dropdown-item:hover {
                background-color: rgba(255,255,255,0.1);
                color: #ffffff;
            }
            
            .dropdown-item i {
                margin-right: 8px;
                width: 20px;
                text-align: center;
            }

            .dropdown-toggle::after {
                margin-left:8px;
            }
            
            /* Ajustes para que la sección de usuario se adapte mejor */
            .user-section {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-left: 16px;
            }
            
            .user-name {
                color: rgba(255,255,255,0.9);
                font-weight: 500;
                padding: 6px 12px;
                background-color: rgba(255,255,255,0.05);
                border-radius: 6px;
                white-space: nowrap;
            }
            
            .btn-logout {
                padding: 6px  19px;
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.2s ease;
                white-space: nowrap;
            }
            
            .btn-logout:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            }

            /* Estilos responsive para móvil */
            @media (max-width: 991.98px) {
                .custom-navbar {
                    padding: 12px 16px;
                }
                
                .navbar-brand-custom {
                    font-size: 19px;
                }
                
                .user-section {
                    flex-direction: column;
                    margin-left: 0;
                    gap: 8px;
                    padding-top: 16px;
                    margin-top: 8px;
                    border-top: 1px solid rgba(255,255,255,0.2);
                    align-items: stretch;
                    width: 100%;
                }
                
                .user-name {
                    text-align: center;
                }
                
                .btn-logout {
                    width: 100%;
                }
                
                .navbar-nav {
                    width: 100%;
                }
                
                .nav-link-custom {
                    margin: 2.4px 0;
                    padding: 9px 16px;
                }
                
                .dropdown-menu {
                    background-color: rgba(0,0,0,0.3);
                    border: none;
                    margin-top: 4px;
                }
                
                .dropdown-item {
                    padding: 9px 20px;
                }
            }

            /* Ajuste para pantallas medianas */
            @media (min-width: 992px) and (max-width: 1199.98px) {
                .nav-link-custom {
                    padding: 8px 12px;
                    font-size: 14px;
                }
                
                .navbar-brand-custom {
                    font-size: 20px;
                    margin-right: 16px;
                }
                
                .user-section {
                    gap: 8px;
                }
            }
        </style>
    </head>

    <body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
            <div class="container-fluid">

            <a class="navbar-brand navbar-brand-custom" href="index.php?accion=inicio"><i class="bi bi-backpack2"></i> SISTEMA DE ALUMNOS</a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav mr-auto">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom" href="index.php?accion=inicio">
                                    <i class="bi bi-house-door"></i> Inicio
                                </a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-link-custom dropdown-toggle" href="#" id="navbarGestion" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-book"></i> Gestión Académica
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarGestion">
                                    <a class="dropdown-item" href="index.php?accion=alumnos">
                                        <i class="bi bi-person-badge"></i> Alumnos
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=materias">
                                        <i class="bi bi-journal-text"></i> Materias
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=calificaciones">
                                        <i class="bi bi-clipboard-check"></i> Calificaciones
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=asistencias">
                                        <i class="bi bi-calendar-check"></i> Asistencias
                                    </a>
                                </div>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-link-custom dropdown-toggle" href="#" id="navbarAdmin" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-gear"></i> Administración
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarAdmin">
                                    <a class="dropdown-item" href="index.php?accion=usuarios">
                                        <i class="bi bi-people"></i> Usuarios
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=profesores">
                                        <i class="bi bi-person-workspace"></i> Profesores
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=aulas">
                                        <i class="bi bi-door-open"></i> Aulas
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=configuracion">
                                        <i class="bi bi-sliders"></i> Configuración
                                    </a>
                                </div>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-link-custom dropdown-toggle" href="#" id="navbarReportes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-file-earmark-bar-graph"></i> Reportes
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarReportes">
                                    <a class="dropdown-item" href="index.php?accion=reporte">
                                        <i class="bi bi-file-text"></i> Reporte General
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=reporte_alumno">
                                        <i class="bi bi-person-lines-fill"></i> Reporte por Alumno
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=reporte_materia">
                                        <i class="bi bi-journal-bookmark"></i> Reporte por Materia
                                    </a>
                                    <a class="dropdown-item" href="index.php?accion=estadisticas">
                                        <i class="bi bi-bar-chart"></i> Estadísticas
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
