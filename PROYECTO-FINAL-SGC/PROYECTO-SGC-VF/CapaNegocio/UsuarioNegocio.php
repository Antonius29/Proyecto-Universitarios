<?php
require_once __DIR__ . '/../CapaDatos/UsuarioDAO.php';
require_once __DIR__ . '/../CapaEntidades/Usuario.php';

/**
 * Clase UsuarioNegocio
 * Esta clase contiene la lógica de negocio relacionada con los usuarios.
 * Se encarga de procesar datos y coordinar las operaciones entre la capa de datos y la presentación.
 */
class UsuarioNegocio {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    /**
     * Método para autenticar un usuario
     * Parámetros:
     * - $email: Correo electrónico del usuario
     * - $password: Contraseña del usuario
     * Retorna: Un objeto Usuario si las credenciales son correctas, null en caso contrario.
     */
    public function autenticar($email, $password) {
        // Validación de formato
        if (empty($email) || empty($password)) {
            throw new Exception("El correo y la contraseña son obligatorios.");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo no es válido.");
        }

        try {
            $usuario = $this->usuarioDAO->autenticar($email, $password);
            return $usuario;
        } catch (UsuarioNoExistenteException $e) {
            throw new Exception("El correo ingresado no está registrado.");
        } catch (CuentaBloqueadaException $e) {
            throw new Exception("La cuenta está bloqueada. Contacte al administrador.");
        } catch (ContraseñaIncorrectaException $e) {
            throw new Exception("Contraseña incorrecta. Intentos restantes: " . $e->getIntentosRestantes());
        } catch (Exception $e) {
            throw new Exception("Error inesperado: " . $e->getMessage());
        }
    }

    /**
     * Registra un nuevo usuario.
     */
    public function registrar($nombre, $email, $password, $rol_id = 2) {
        if (empty($nombre) || empty($email) || empty($password)) {
            throw new Exception("Todos los campos de registro son obligatorios.");
        }

        if (strlen($password) < 6) {
            throw new Exception("La contraseña es muy corta (mínimo 6 caracteres).");
        }

        // Crear la entidad
        $usuario = new Usuario(
            null, 
            $nombre,
            $email,
            $password,
            $rol_id,
            1 // activo por defecto
        );

        return $this->usuarioDAO->registrar($usuario);
    }

    /**
     * Listar todos los usuarios.
     */
  public function listar() {
        $lista = $this->usuarioDAO->listar();
        if (!$lista) {
            return []; // Devolvemos un array vacío en lugar de nada
        }
        return $lista;
    }

    /**
     * Obtener un usuario por ID.
     */
    public function obtenerPorId($id) {
        if (empty($id)) {
            throw new Exception("ID de usuario no válido.");
        }
        return $this->usuarioDAO->obtenerPorId($id);
    }

    /**
     * Desbloquear una cuenta (Uso administrativo).
     */
    public function desbloquear($id) {
        if (empty($id)) {
            throw new Exception("ID requerido para desbloquear.");
        }
        return $this->usuarioDAO->desbloquearCuenta($id);
    }

    /**
     * Método para manejar solicitudes de desbloqueo
     * Parámetros:
     * - $usuarioId: ID del usuario que solicita el desbloqueo
     * Retorna: true si la solicitud se procesa correctamente, false en caso contrario.
     */
    public function manejarSolicitudDesbloqueo($usuarioId) {
        // ...lógica para manejar la solicitud de desbloqueo...
    }

    /**
     * Método para verificar si un usuario está bloqueado
     * Parámetros:
     * - $email: Correo electrónico del usuario
     * Retorna: true si el usuario está bloqueado, false en caso contrario.
     */
    public function verificarBloqueo($email) {
        // ...lógica para verificar el estado de bloqueo del usuario...
    }

    // Otros métodos relacionados con la lógica de negocio de usuarios...
}