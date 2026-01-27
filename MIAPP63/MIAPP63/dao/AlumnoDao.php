<?php
require_once __DIR__ . '/../bd/Conexion.php';
require_once __DIR__ . '/../modelo/Alumno.php';

class AlumnoDao {
    
    public function listarTodos() {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        $stmt = $pdo->prepare('SELECT * FROM alumnos ORDER BY id DESC');
        $stmt->execute();
        
        $alumnos = [];
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $alumno = new Alumno();
            $alumno->id = $row->id;
            $alumno->cedula = $row->cedula;
            $alumno->nombre = $row->nombre;
            $alumno->apellido = $row->apellido;
            $alumno->correo = $row->correo;
            $alumno->telefono = $row->telefono;
            $alumno->fecha_nacimiento = $row->fecha_nacimiento;
            $alumno->curso = $row->curso;
            $alumno->estado = $row->estado;
            $alumno->fecha_registro = $row->fecha_registro;
            $alumnos[] = $alumno;
        }
        
        return $alumnos;
    }
    
    public function obtenerPorId($id) {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        $stmt = $pdo->prepare('SELECT * FROM alumnos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        if (!$row) {
            return null;
        }
        
        $alumno = new Alumno();
        $alumno->id = $row->id;
        $alumno->cedula = $row->cedula;
        $alumno->nombre = $row->nombre;
        $alumno->apellido = $row->apellido;
        $alumno->correo = $row->correo;
        $alumno->telefono = $row->telefono;
        $alumno->fecha_nacimiento = $row->fecha_nacimiento;
        $alumno->curso = $row->curso;
        $alumno->estado = $row->estado;
        $alumno->fecha_registro = $row->fecha_registro;
        
        return $alumno;
    }
    
    public function insertar($alumno) {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        $stmt = $pdo->prepare('INSERT INTO alumnos (cedula, nombre, apellido, correo, telefono, fecha_nacimiento, curso, estado) 
                               VALUES (:cedula, :nombre, :apellido, :correo, :telefono, :fecha_nacimiento, :curso, :estado)');
        
        return $stmt->execute([
            'cedula' => $alumno->cedula,
            'nombre' => $alumno->nombre,
            'apellido' => $alumno->apellido,
            'correo' => $alumno->correo,
            'telefono' => $alumno->telefono,
            'fecha_nacimiento' => $alumno->fecha_nacimiento,
            'curso' => $alumno->curso,
            'estado' => $alumno->estado
        ]);
    }
    
    public function actualizar($alumno) {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        $stmt = $pdo->prepare('UPDATE alumnos SET 
            cedula = :cedula,
            nombre = :nombre,
            apellido = :apellido,
            correo = :correo,
            telefono = :telefono,
            fecha_nacimiento = :fecha_nacimiento,
            curso = :curso,
            estado = :estado
            WHERE id = :id');
        
        return $stmt->execute([
            'cedula' => $alumno->cedula,
            'nombre' => $alumno->nombre,
            'apellido' => $alumno->apellido,
            'correo' => $alumno->correo,
            'telefono' => $alumno->telefono,
            'fecha_nacimiento' => $alumno->fecha_nacimiento,
            'curso' => $alumno->curso,
            'estado' => $alumno->estado,
            'id' => $alumno->id
        ]);
    }
    
    public function eliminar($id) {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        $stmt = $pdo->prepare('DELETE FROM alumnos WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
?>