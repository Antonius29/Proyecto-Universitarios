<?php
include __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../dao/AlumnoDao.php';

$alumnoDao = new AlumnoDao();
$alumnos = $alumnoDao->listarTodos();
?>

<div class="container-fluid my-5">
    <?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> Operación realizada exitosamente
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> Error al realizar la operación
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users"></i> Consulta de Alumnos</h5>
                <a href="index.php?accion=registrarAlumno" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Registrar Alumno
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($alumnos) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Fecha Nacimiento</th>
                                <th>Curso</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alumnos as $alumno): ?>
                            <tr>
                                <td><?= htmlspecialchars($alumno->cedula) ?></td>
                                <td><?= htmlspecialchars($alumno->nombre) ?></td>
                                <td><?= htmlspecialchars($alumno->apellido) ?></td>
                                <td><?= htmlspecialchars($alumno->correo) ?></td>
                                <td><?= htmlspecialchars($alumno->telefono) ?></td>
                                <td><?= htmlspecialchars($alumno->fecha_nacimiento) ?></td>
                                <td><?= htmlspecialchars($alumno->curso) ?></td>
                                <td>
                                    <?php if ($alumno->estado === 'Activo'): ?>
                                        <span class="badge badge-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-info btn-sm" 
                                            title="Ver información"
                                            data-toggle="modal" 
                                            data-target="#modalVer<?= $alumno->id ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="index.php?accion=editarAlumno&id=<?= $alumno->id ?>" 
                                       class="btn btn-warning btn-sm" 
                                       title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            title="Eliminar"
                                            data-toggle="modal" 
                                            data-target="#modalEliminar<?= $alumno->id ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> No hay estudiantes registrados
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODALES FUERA DE LA TABLA -->
<?php foreach ($alumnos as $alumno): ?>

<!-- Modal Ver Información -->
<div class="modal fade" id="modalVer<?= $alumno->id ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user"></i> Información del Alumno
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Cédula:</th>
                        <td><?= htmlspecialchars($alumno->cedula) ?></td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td><?= htmlspecialchars($alumno->nombre) ?></td>
                    </tr>
                    <tr>
                        <th>Apellido:</th>
                        <td><?= htmlspecialchars($alumno->apellido) ?></td>
                    </tr>
                    <tr>
                        <th>Correo:</th>
                        <td><?= htmlspecialchars($alumno->correo) ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?= htmlspecialchars($alumno->telefono) ?></td>
                    </tr>
                    <tr>
                        <th>Fecha Nacimiento:</th>
                        <td><?= htmlspecialchars($alumno->fecha_nacimiento) ?></td>
                    </tr>
                    <tr>
                        <th>Curso:</th>
                        <td><?= htmlspecialchars($alumno->curso) ?></td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            <?php if ($alumno->estado === 'Activo'): ?>
                                <span class="badge badge-success">Activo</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Inactivo</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha Registro:</th>
                        <td><?= htmlspecialchars($alumno->fecha_registro) ?></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmar Eliminación -->
<div class="modal fade" id="modalEliminar<?= $alumno->id ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar al alumno:</p>
                <p class="font-weight-bold text-center">
                    <?= htmlspecialchars($alumno->nombre . ' ' . $alumno->apellido) ?>
                </p>
                <p class="text-danger text-center">
                    <small>Esta acción no se puede deshacer.</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a href="index.php?accion=eliminarAlumno&id=<?= $alumno->id ?>" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                </a>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
