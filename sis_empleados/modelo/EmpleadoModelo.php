<?php
require_once __DIR__ . '/../config/conexion.php';

class EmpleadoModelo
{
    public function insertar($datos)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->conectar();

            $sql = "INSERT INTO empleados (nombre, cargo, salario) VALUES (:nombre, :cargo, :salario)";
            
            $stmt = $conn->prepare($sql);
            $params = [
                'nombre' => $datos['nombre'],
                'cargo' => $datos['cargo'],
                'salario' => $datos['salario']
            ];
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerTodos()
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->conectar();

            $sql = "SELECT * FROM empleados ORDER BY id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function eliminar($id)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->conectar();

            $sql = "DELETE FROM empleados WHERE id = :id";
            $stmt = $conn->prepare($sql);
            
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
