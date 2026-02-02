<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .welcome-container {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        .logout-link {
            display: block;
            margin-top: 20px;
            color: #3cb3a0;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>BIENVENIDO</h1>
        <p>Has iniciado sesión como: <strong><?php echo $_SESSION['usuario']; ?></strong></p>
        <hr>
        <p>Este es tu panel principal.</p>
        <a href="logout.php" class="logout-link">Cerrar Sesión</a>
    </div>
</body>
</html>