<?php
require_once 'config.php';
verificarSesion();
$nombreUsuario = obtenerNombreUsuario();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos - Sistema de Gestión</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .documento-filtros {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .buscador {
            flex: 1;
            min-width: 250px;
        }
        
        .buscador input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .filtros-rapidos {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        .form-file {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }
        
        .file-input-label {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }
        
        .file-selected {
            color: #28a745;
            font-size: 0.9em;
        }
        
        .documento-tamano {
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 0.85em;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>SGC</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="contactos.php">Equipo</a></li>
                <li><a href="oportunidades.php">Proyectos</a></li>
                <li><a href="actividades.php">Tareas</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="documentos.php" class="active">Documentos</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Gestión de Documentos</h1>
                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($nombreUsuario); ?></span>
                    <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
                </div>
            </header>

            <div class="content">
                <!-- BARRA DE ACCIONES -->
                <div class="action-bar">
                    <button class="btn btn-primary" onclick="mostrarFormulario()">Nuevo Documento</button>
                </div>

                <!-- FORMULARIO DE NUEVO DOCUMENTO -->
                <div id="formularioDocumento" class="form-section" style="display:none; margin-bottom: 30px; border: 2px solid #007bff; padding: 20px; border-radius: 8px;">
                    <h2 id="tituloFormulario">Nuevo Documento</h2>
                    <form id="formDocumento" enctype="multipart/form-data" onsubmit="guardarDocumento(event)">
                        <input type="hidden" id="documentoId" name="id">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <!-- Proyecto -->
                            <div class="form-group">
                                <label for="proyecto_id">Proyecto *</label>
                                <select id="proyecto_id" name="proyecto_id" required>
                                    <option value="">Seleccione un proyecto</option>
                                </select>
                            </div>

                            <!-- Categoría -->
                            <div class="form-group">
                                <label for="categoria_id">Categoría *</label>
                                <select id="categoria_id" name="categoria_id" required>
                                    <option value="">Seleccione una categoría</option>
                                </select>
                            </div>

                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre">Nombre *</label>
                                <input type="text" id="nombre" name="nombre" placeholder="Ej: Especificación técnica" required>
                            </div>

                            <!-- Descripción -->
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" id="descripcion" name="descripcion" placeholder="Detalles del documento">
                            </div>
                        </div>

                        <!-- Archivo o URL -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                            <div class="form-group form-file">
                                <label>Archivo</label>
                                <div class="file-input-wrapper">
                                    <input type="file" id="archivo" name="archivo">
                                    <label for="archivo" class="file-input-label">Seleccionar archivo</label>
                                </div>
                                <span id="nombreArchivo" class="file-selected"></span>
                            </div>

                            <div class="form-group">
                                <label for="url_externa">URL Externa (alternativa)</label>
                                <input type="url" id="url_externa" name="url_externa" placeholder="https://...">
                            </div>
                        </div>

                        <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary">Guardar Documento</button>
                            <button type="button" class="btn btn-secondary" onclick="ocultarFormulario()">Cancelar</button>
                        </div>
                    </form>
                </div>

                <!-- BUSCADOR DE DOCUMENTOS -->
                <div class="documento-filtros">
                    <div class="buscador">
                        <input type="text" id="busqueda" placeholder="Buscar documentos por nombre...">
                    </div>
                </div>

                <!-- FILTROS POR CATEGORÍA -->
                <div style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-radius: 5px;">
                    <small style="color: #666;">Filtrar por categoría:</small>
                    <div class="filtros-rapidos" id="filtrosCategorias"></div>
                </div>

                <!-- TABLA DE DOCUMENTOS -->
                <div class="table-section">
                    <h2>Documentos Registrados</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Proyecto</th>
                                <th>Categoría</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Subido por</th>
                                <th>Archivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDocumentos">
                            <tr>
                                <td colspan="8" class="text-center">Cargando documentos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Mostrar nombre del archivo seleccionado
        document.getElementById('archivo').addEventListener('change', function() {
            const nombreArchivo = document.getElementById('nombreArchivo');
            if (this.files.length > 0) {
                nombreArchivo.textContent = '✓ ' + this.files[0].name;
            } else {
                nombreArchivo.textContent = '';
            }
        });
    </script>
    <script src="js/documentos.js"></script>
</body>
</html>
