<?php
ob_start();
session_start();

if (headers_sent($file, $line)) {
    $headers_error = "Advertencia: las cabeceras ya fueron enviadas en $file en la línea $line.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $email_correcto = "admin@correo.com";
    $pass_correcta = "123456";

    if ($email === $email_correcto && $password === $pass_correcta) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = $email;

        if (!headers_sent()) {
            header("Location: menu.php");
            exit();
        } else {
            echo '<script>window.location.href = "menu.php";</script>';
            exit();
        }
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="login-container">
        <div class="header">
            <h1>INICIO DE SESIÓN</h1>
            <p>Por favor, introduce tus credenciales</p>
            <hr>
        </div>

        <?php if (isset($error)): ?>
            <p style="color: #ff4d4d; font-size: 13px; font-weight: bold;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($headers_error)): ?>
            <p style="color: #ff9900; font-size: 13px; font-weight: bold;"><?php echo $headers_error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="input-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="input-group">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>

            <button type="submit" class="btn-login">
                Iniciar Sesión
            </button>
        </form>
    </div>

</body>
</html>