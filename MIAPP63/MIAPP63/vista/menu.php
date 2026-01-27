<?php 
include __DIR__ . '/layout/header.php'; 
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
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="m-0">Menú Principal</h2>
            <p class="text-muted mb-0">Bienvenido al sistema</p>
        </div>
        <div>
            <a class="btn btn-dark" href="index.php?accion=inicio">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    <!-- TARJETAS DE OPCIONES -->
    <div class="row">
        <!-- Opción Alumnos -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Alumnos</h5>
                    <p class="card-text">Consultar y gestionar estudiantes</p>
                    <a href="index.php?accion=consultarAlumno" class="btn btn-primary">
                        <i class="fas fa-list"></i> Consultar
                    </a>
                </div>
            </div>
        </div>

        <!-- Opción Docentes -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-chalkboard-user fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Docentes</h5>
                    <p class="card-text">Consultar y gestionar docentes</p>
                    <a href="index.php?accion=consultarDocente" class="btn btn-info">
                        <i class="fas fa-list"></i> Consultar
                    </a>
                </div>
            </div>
        </div>

        <!-- Opción Carreras -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-graduation-cap fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Carreras</h5>
                    <p class="card-text">Consultar carreras disponibles</p>
                    <a href="index.php?accion=consultarCarrera" class="btn btn-success">
                        <i class="fas fa-list"></i> Consultar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>