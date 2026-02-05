<?php
require_once __DIR__ . '/Conexion.php';
require_once __DIR__ . '/../CapaEntidades/Usuario.php';
require_once __DIR__ . '/../CapaExcepciones/UsuarioNoExistenteException.php';
require_once __DIR__ . '/../CapaExcepciones/ContraseñaIncorrectaException.php';
require_once __DIR__ . '/../CapaExcepciones/CuentaBloqueadaException.php';

// Clase UsuarioDAO
// Esta clase se encarga de realizar operaciones relacionadas con la tabla `Usuario` en la base de datos.
// Incluye métodos para autenticar usuarios, registrar solicitudes de desbloqueo, y más.
class UsuarioDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion();
    }

    // Método para autenticar un usuario
    // Parámetros:
    // - $email: Correo electrónico del usuario
    // - $password: Contraseña del usuario
    // Retorna: Un objeto Usuario si las credenciales son correctas, null en caso contrario.
    public function autenticar($email, $password) {
        try {
            $sql = "CALL sp_usuario_autenticar(?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$email]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // Cerrar el cursor para evitar errores de resultados pendientes

            if (!$row) {
                throw new UsuarioNoExistenteException("El correo no existe.");
            }

            if ($row['bloqueado']) {
                throw new CuentaBloqueadaException("Tu cuenta ha sido bloqueada por seguridad.", $email, $row['fecha_bloqueo']);
            }

            if ($row['password'] !== $password) {
                $intentosFallidos = $row['intentos_fallidos'] + 1;

                if ($intentosFallidos >= 3) {
                    $sqlBloqueo = "UPDATE Usuario SET bloqueado = TRUE, fecha_bloqueo = NOW() WHERE id = ?";
                    $stmtBloqueo = $this->conexion->prepare($sqlBloqueo);
                    $stmtBloqueo->execute([$row['id']]);

                    throw new CuentaBloqueadaException("Tu cuenta ha sido bloqueada por seguridad.", $email, date('Y-m-d H:i:s'));
                }

                $sqlIntentos = "UPDATE Usuario SET intentos_fallidos = ? WHERE id = ?";
                $stmtIntentos = $this->conexion->prepare($sqlIntentos);
                $stmtIntentos->execute([$intentosFallidos, $row['id']]);

                throw new ContraseñaIncorrectaException("La contraseña es incorrecta.", 3 - $intentosFallidos);
            }

            $sqlReset = "UPDATE Usuario SET intentos_fallidos = 0 WHERE id = ?";
            $stmtReset = $this->conexion->prepare($sqlReset);
            $stmtReset->execute([$row['id']]);

            return new Usuario($row['id'], $row['nombre'], $row['email'], $row['password'], $row['rol_id'], $row['activo']);
        } catch (PDOException $e) {
            error_log("Error en la base de datos: " . $e->getMessage());
            throw new Exception("Error del sistema: " . $e->getMessage());
        }
    }
    /**
     * Registra un nuevo usuario usando sp_usuario_registrar
     */
    public function registrar(Usuario $usuario) {
        $sql = "CALL sp_usuario_registrar(?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $usuario->getNombre(),
            $usuario->getEmail(),
            $usuario->getPassword(),
            $usuario->getRolId()
        ]);
    }

    /**
     * Lista todos los usuarios
     */
    public function listar() {
    $sql = "CALL sp_usuario_listar()";
    $stmt = $this->conexion->query($sql);
    $usuarios = []; // Se crea la lista vacía
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usuarios[] = new Usuario(
            $row['id'], $row['nombre'], $row['email'], 
            $row['password'], $row['rol_id'], $row['activo']
        );
    }
    return $usuarios; // ESTA LÍNEA ES CLAVE
}

    /**
     * Obtiene un usuario por ID
     */
    public function obtenerPorId($id) {
        $sql = "CALL sp_usuario_obtener_uno(?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Usuario(
                $row['id'], $row['nombre'], $row['email'], 
                $row['password'], $row['rol_id'], $row['activo']
            );
        }
        return null;
    }

    /**
     * Desbloquea una cuenta usando sp_usuario_desbloquear
     */
    public function desbloquearCuenta($id) {
        $sql = "CALL sp_usuario_desbloquear(?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Registra una solicitud de desbloqueo
     */
    public function registrarSolicitudDesbloqueo($usuarioId) {
        try {
            $sql = "CALL sp_registrar_solicitud_desbloqueo(?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuarioId]);
            $stmt->closeCursor();
        } catch (PDOException $e) {
            error_log("Error al registrar solicitud de desbloqueo: " . $e->getMessage());
            throw new Exception("No se pudo registrar la solicitud de desbloqueo.");
        }
    }

    /**
     * Lista las solicitudes de desbloqueo
     */
    public function listarSolicitudesDesbloqueo() {
        try {
            $sql = "CALL sp_listar_solicitudes_desbloqueo()";
            $stmt = $this->conexion->query($sql);
            $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $solicitudes;
        } catch (PDOException $e) {
            error_log("Error al listar solicitudes de desbloqueo: " . $e->getMessage());
            throw new Exception("No se pudieron listar las solicitudes de desbloqueo.");
        }
    }

    // Método para buscar un usuario por su correo electrónico
    // Parámetros:
    // - $email: Correo electrónico del usuario
    // Retorna: Un objeto Usuario si se encuentra, null en caso contrario.
    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT * FROM Usuario WHERE email = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            if ($row) {
                return new Usuario(
                    $row['id'],
                    $row['nombre'],
                    $row['email'],
                    $row['password'],
                    $row['rol_id'],
                    $row['activo'],
                    $row['intentos_fallidos'],
                    $row['bloqueado'],
                    $row['fecha_bloqueo']
                );
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error al buscar usuario por email: " . $e->getMessage());
            throw new Exception("Error al buscar usuario por email.");
        }
    }
}