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
    <title>Tareas - Sistema de Gestión</title>
    <link rel="stylesheet" href="css/estilos.css">
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
                <li><a href="actividades.php" class="active">Tareas</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="documentos.php">Documentos</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Gestión de Tareas</h1>

                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($nombreUsuario); ?></span>
                    <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
                </div>
            </header>

            <div class="content">

                <div class="action-bar">
                    <button class="btn btn-primary" onclick="mostrarFormulario()">Nueva Tarea</button>
                </div>

                <div id="formularioTarea" class="form-container" style="display:none;">
                    <h3>Agregar Tarea</h3>
                    <form id="formTarea" onsubmit="guardarTarea(event)">
                        <input type="hidden" id="tareaId" name="id">
                        
                        <div class="form-group">
                            <label for="proyecto_id">Proyecto *</label>
                            <select id="proyecto_id" name="proyecto_id" required>
                                <option value="">Seleccione un proyecto</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipo_tarea_id">Tipo de Tarea *</label>
                            <select id="tipo_tarea_id" name="tipo_tarea_id" required>
                                <option value="">Seleccione tipo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="usuario_id">Asignado a *</label>
                            <select id="usuario_id" name="usuario_id" required>
                                <option value="">Seleccione usuario</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="estado_tarea_id">Estado *</label>
                            <select id="estado_tarea_id" name="estado_tarea_id" required>
                                <option value="">Seleccione estado</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" onclick="ocultarFormulario()">Cancelar</button>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Proyecto</th>
                                <th>Tipo</th>
                                <th>Asignado a</th>
                                <th>Estado</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody id="tablaTareas">
                            <tr>
                                <td colspan="7" class="text-center">Cargando datos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="js/actividades.js"></script>
</body>
</html>
