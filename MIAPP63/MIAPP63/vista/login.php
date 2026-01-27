<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>

        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-danger text-center" role="alert">
            Usuario o contraseña incorrectos. Por favor, inténtelo de nuevo.
        </div>
        <?php endif; ?>

        <form action="index.php?accion=procesarLogin" method="POST">

            <div class="form-group mb-3">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="username" name="usuario" placeholder="Ingrese su usuario" required>
            </div>

            <div class="form-group mb-3">
                <label for="clave" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese su contraseña" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>

            <div class="mt-3 text-center">
                <a href="index.php?accion=inicio">Volver al inicio</a>
            </div>

        </form>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>