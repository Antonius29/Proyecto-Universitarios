<?php
class Conexion
{
    private $host = "localhost";
    private $usuario = "root";
    private $contrasena = "admin";
    private $base_datos = "sistema_alumno";
    private $port = "3306";

    public function conectar()
    {
        try {
            $conexion = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->base_datos", 
            $this->usuario, $this->contrasena);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}
?>