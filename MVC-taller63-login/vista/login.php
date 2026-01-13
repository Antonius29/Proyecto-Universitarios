<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Century Gothic', sans-serif;
            background-color: #000000;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container-login {
            max-width: 400px;
            padding: 40px;
            border-radius: 10px;
            background-color: #212529;
            margin: auto;
            margin-top: 80px;
        }

        label {
            font-weight: 600;
            color: #ffffff;
        }

        footer {
            text-align: center;
            padding: 15px 0;
        }

        footer small {
            color: #000000;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container container-login mt-5" style="max-width: 400px;">
        <h3 class="mb-4 text-center text-white"><b>INICIAR SESIÓN</b></h3>

        <form action="/index.php?accion=login" method="post">

            <div class="form-group">
                <label for="usuario"><b>Usuario:</b></label>
                <input type="text" class="form-control" name="usuario" required>
            </div>

            <div class="form-group">
                <label for="clave"><b>Clave:</b></label>
                <input type="password" class="form-control" name="clave" required>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary btn-block"><b>Ingresar</b></button>

        </form>
    </div>

    <footer>
        <div class="text-center mt-4">

            <small>&copy; 2026 Sistema de Alumnos. Todos los derechos reservados.</small>
        </div>
    </footer>
</body>
</html>
