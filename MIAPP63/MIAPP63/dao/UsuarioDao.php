<?php
require_once __DIR__ . '/../bd/Conexion.php';
require_once __DIR__ . '/../modelo/Usuario.php';

class UsuarioDao {
    
    public function autenticar($usuario, $clave) {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND clave = :clave');
        $stmt->execute([
            'usuario' => $usuario,
            'clave' => $clave
        ]);
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($fila) {
            $usuarioObj = new Usuario();
            $usuarioObj->id = $fila['id'];
            $usuarioObj->usuario = $fila['usuario'];
            $usuarioObj->clave = $fila['clave'];
            return $usuarioObj;
        }
        
        return null;
    }
}
?>