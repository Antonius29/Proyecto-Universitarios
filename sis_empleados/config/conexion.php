<?php

class Conexion 
{
    public function conectar() {
        $host = "localhost";
        $dbname = "sis_empleados";
        $user = "root";     
        $password = "admin";

        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $password);

            // Manejo de errores con excepciones
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

?>
