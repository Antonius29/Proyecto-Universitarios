<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container-xl mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">FORMULARIO DE ALUMNO</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($mensaje)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $mensaje; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?accion=guardar">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cedula"><b>Cédula:</b></label>
                                <input type="text" class="form-control" id="cedula" name="cedula" 
                                       placeholder="Ej: 0912345678" required maxlength="10">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre"><b>Nombre:</b></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       placeholder="Ingrese el nombre" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="apellido"><b>Apellido:</b></label>
                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                       placeholder="Ingrese el apellido" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="correo"><b>Correo:</b></label>
                                <input type="email" class="form-control" id="correo" name="correo" 
                                       placeholder="Ej: correo@example.com" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="telefono"><b>Teléfono:</b></label>
                                <input type="text" class="form-control" id="telefono" name="telefono" 
                                       placeholder="Ej: +593 98 765 4321">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fecha_nacimiento"><b>Fecha de Nacimiento:</b></label>
                                <input type="date" class="form-control" id="fecha_nacimiento" 
                                       name="fecha_nacimiento" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="curso"><b>Curso:</b></label>
                                <input type="text" class="form-control" id="curso" name="curso" 
                                       placeholder="Ingrese el curso" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="estado"><b>Estado:</b></label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block"><b>Guardar Alumno</b></button>
                        </div>
                        <div class="form-group">
                            <a href="index.php?accion=reporte" class="btn btn-secondary btn-block"><b>Volver al Listado</b></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
