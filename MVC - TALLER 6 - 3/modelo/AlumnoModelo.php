<?php
require_once __DIR__ . '/../config/conexion.php';

class AlumnoModelo
{
    public function obtenerTodos()
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->conectar();

           // Consulta SQL para obtener todos los alumnos
           $sql = "SELECT * FROM alumnos";
           $stmt = $conn->query($sql);
           return $stmt->fetchAll(PDO::FETCH_ASSOC);


        } catch (PDOException $e) {
            error_log("Error en AlumnoModelo->obtenerTodos - " . $e->getMessage());
            return [];
        }
    }
    public function buscarPorNombre($nombre)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->conectar();

            // Consulta SQL para buscar por nombre
            $sql = "SELECT * FROM alumnos WHERE nombre LIKE :nombre";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['nombre' => '%' . $nombre . '%']);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en AlumnoModelo->buscarPorNombre - " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorApellido($apellido)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->conectar();

            // Consulta SQL para buscar por apellido
            $sql = "SELECT * FROM alumnos WHERE apellido LIKE :apellido";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['apellido' => '%' . $apellido . '%']);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en AlumnoModelo->buscarPorApellido - " . $e->getMessage());
            return [];
        }
    }

    public function guardar($cedula, $nombre, $apellido, $correo, $telefono, $fecha_nacimiento, $curso, $estado)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->conectar();

            // Validar que la cédula no exista
            $sqlValidar = "SELECT id FROM alumnos WHERE cedula = :cedula";
            $stmtValidar = $conn->prepare($sqlValidar);
            $stmtValidar->execute(['cedula' => $cedula]);

            if ($stmtValidar->rowCount() > 0) {
                return [
                    'success' => false,
                    'mensaje' => 'La cédula ya está registrada'
                ];
            }

            // Insertar nuevo alumno
            $sql = "INSERT INTO alumnos (cedula, nombre, apellido, correo, telefono, fecha_nacimiento, curso, estado) 
                    VALUES (:cedula, :nombre, :apellido, :correo, :telefono, :fecha_nacimiento, :curso, :estado)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':correo' => $correo,
                ':telefono' => $telefono,
                ':fecha_nacimiento' => $fecha_nacimiento,
                ':curso' => $curso,
                ':estado' => $estado
            ]);

            return [
                'success' => true,
                'mensaje' => 'Alumno guardado correctamente'
            ];

        } catch (PDOException $e) {
            error_log("Error en AlumnoModelo->guardar - " . $e->getMessage());
            return [
                'success' => false,
                'mensaje' => 'Error al guardar el alumno: ' . $e->getMessage()
            ];
        }
    }
}