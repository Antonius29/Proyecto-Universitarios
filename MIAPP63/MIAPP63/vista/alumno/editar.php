<?php 
include __DIR__ . '/../layout/header.php'; 
require_once __DIR__ . '/../../dao/AlumnoDao.php';

$alumnoDao = new AlumnoDao();
$alumno = $alumnoDao->obtenerPorId($_GET['id']);

if (!$alumno) {
    header('Location: index.php?accion=consultarAlumno&error=alumno_no_encontrado');
    exit();
}
?>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Editar Alumno</h5>
        </div>
        <div class="card-body">
            <form action="index.php?accion=actualizarAlumno" method="POST">
                <input type="hidden" name="id" value="<?= $alumno->id ?>">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" 
                               value="<?= htmlspecialchars($alumno->cedula) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               value="<?= htmlspecialchars($alumno->nombre) ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                               value="<?= htmlspecialchars($alumno->apellido) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" 
                               value="<?= htmlspecialchars($alumno->correo) ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" 
                               value="<?= htmlspecialchars($alumno->telefono) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" 
                               value="<?= htmlspecialchars($alumno->fecha_nacimiento) ?>">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="curso" class="form-label">Curso</label>
                        <input type="text" class="form-control" id="curso" name="curso" 
                               value="<?= htmlspecialchars($alumno->curso) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="Activo" <?= $alumno->estado === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $alumno->estado === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="index.php?accion=menu" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>