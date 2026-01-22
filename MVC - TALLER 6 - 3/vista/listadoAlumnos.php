<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <h4 class="mb-4 text-center">LISTADO DE ALUMNOS</h4>

            <!-- Filtros -->
            <div class="bg-dark text-white p-3 mb-4 rounded">
                <h6 class="font-weight-bold mb-3">Filtrar por:</h6>
                <form method="GET">
                    <input type="hidden" name="accion" value="reporte">
                    <div class="form-row align-items-end">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label for="tipo_busqueda"><b>Tipo de busqueda:</b></label>
                            <select class="form-control" id="tipo_busqueda" name="tipo_busqueda">
                                <option value="todos" <?php echo ($tipo_busqueda === 'todos') ? 'selected' : ''; ?>>Todos</option>
                                <option value="nombre" <?php echo ($tipo_busqueda === 'nombre') ? 'selected' : ''; ?>>Por Nombre</option>
                                <option value="apellido" <?php echo ($tipo_busqueda === 'apellido') ? 'selected' : ''; ?>>Por Apellido</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-3 mb-md-0">
                            <label for="valor_busqueda"><b>Buscar:</b></label>
                            <input type="text" class="form-control" id="valor_busqueda" name="valor_busqueda" 
                                   placeholder="Ingrese el termino de busqueda" 
                                   value="<?php echo htmlspecialchars($valor_busqueda); ?>">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-block"><b>Buscar</b></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contador -->
            <p class="mb-4">
                <span class="badge badge-success p-3" style="font-size: 15px;">Registros encontrados: <?php echo $cantidad; ?></span>
            </p>

            <!-- Tabla -->
            <table class="table table-striped table-bordered table-hover" style="font-size:17px;">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center" style="white-space: nowrap;">Cedula</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Apellido</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center" style="white-space: nowrap;">Telefono</th>
                        <th class="text-center" style="white-space: nowrap;">Fecha Nacimiento</th>
                        <th class="text-center">Curso</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center" style="white-space: nowrap;">Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $fila): ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($fila['id']); ?></td>
                        <td class="text-center" style="white-space: nowrap;"><?php echo htmlspecialchars($fila['cedula']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($fila['nombre']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($fila['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                        <td class="text-center" style="white-space: nowrap;"><?php echo htmlspecialchars($fila['telefono']); ?></td>
                        <td class="text-center" style="white-space: nowrap;"><?php echo htmlspecialchars($fila['fecha_nacimiento']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($fila['curso']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($fila['estado']); ?></td>
                        <td class="text-center" style="white-space: nowrap;"><?php echo htmlspecialchars($fila['fecha_registro']); ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($alumnos)): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">No existen registros</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>