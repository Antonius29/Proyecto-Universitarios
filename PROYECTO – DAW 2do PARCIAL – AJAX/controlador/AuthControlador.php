<?php
/**
 * Controlador de Autenticacion
 * Maneja login, registro y logout
 */
require_once 'config/Conexion.php';
require_once 'modelo/Usuario.php';
require_once 'dao/UsuarioDAO.php';

class AuthControlador {
    
    private $usuarioDAO;
    
    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }
    
    /**
     * Mostrar formulario de login
     */
    public function login() {
        // Si ya esta autenticado, redirigir al dashboard
        if (isset($_SESSION['usuario_id'])) {
            header('Location: index.php?modulo=dashboard&accion=index');
            exit;
        }
        
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
        $mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
        unset($_SESSION['error'], $_SESSION['mensaje']);
        
        include 'vista/auth/login.php';
    }
    
    /**
     * Procesar formulario de login
     */
    public function procesar_login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?modulo=auth&accion=login');
            exit;
        }
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validaciones
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Por favor complete todos los campos';
            header('Location: index.php?modulo=auth&accion=login');
            exit;
        }
        
        // Buscar usuario por email
        $usuario = $this->usuarioDAO->obtenerPorEmail($email);
        
        if (!$usuario) {
            $_SESSION['error'] = 'Credenciales incorrectas';
            header('Location: index.php?modulo=auth&accion=login');
            exit;
        }
        
        // Verificar contrasena
        if ($password !== $usuario['password']) {
            $_SESSION['error'] = 'Credenciales incorrectas';
            header('Location: index.php?modulo=auth&accion=login');
            exit;
        }
        
        // Verificar estado del usuario
        if ($usuario['estado'] !== 'activo') {
            $_SESSION['error'] = 'Su cuenta esta inactiva. Contacte al administrador.';
            header('Location: index.php?modulo=auth&accion=login');
            exit;
        }
        
        // Crear sesion
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
        
        $_SESSION['mensaje'] = 'Bienvenido, ' . $usuario['nombre'];
        header('Location: index.php?modulo=dashboard&accion=index');
        exit;
    }
    
    /**
     * Mostrar formulario de registro
     */
    public function registro() {
        // Si ya esta autenticado, redirigir al dashboard
        if (isset($_SESSION['usuario_id'])) {
            header('Location: index.php?modulo=dashboard&accion=index');
            exit;
        }
        
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
        $datos = isset($_SESSION['datos_registro']) ? $_SESSION['datos_registro'] : [];
        unset($_SESSION['error'], $_SESSION['datos_registro']);
        
        include 'vista/auth/registro.php';
    }
    
    /**
     * Procesar formulario de registro
     */
    public function procesar_registro() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?modulo=auth&accion=registro');
            exit;
        }
        
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Guardar datos para mostrar en caso de error
        $_SESSION['datos_registro'] = [
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono
        ];
        
        // Validaciones
        if (empty($nombre) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Por favor complete todos los campos obligatorios';
            header('Location: index.php?modulo=auth&accion=registro');
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El correo electronico no es valido';
            header('Location: index.php?modulo=auth&accion=registro');
            exit;
        }
        
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'La contrasena debe tener al menos 8 caracteres';
            header('Location: index.php?modulo=auth&accion=registro');
            exit;
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Las contrasenas no coinciden';
            header('Location: index.php?modulo=auth&accion=registro');
            exit;
        }
        
        // Verificar si el email ya existe
        if ($this->usuarioDAO->obtenerPorEmail($email)) {
            $_SESSION['error'] = 'El correo electronico ya esta registrado';
            header('Location: index.php?modulo=auth&accion=registro');
            exit;
        }
        
        // Crear usuario
        $usuario = new Usuario();
        $usuario->setNombre($nombre);
        $usuario->setEmail($email);
        $usuario->setTelefono($telefono);
        $usuario->setPassword($password);
        $usuario->setRol('empleado');
        $usuario->setEstado('activo');
        
        if ($this->usuarioDAO->crear($usuario)) {
            unset($_SESSION['datos_registro']);
            $_SESSION['mensaje'] = 'Registro exitoso. Ahora puede iniciar sesion.';
            header('Location: index.php?modulo=auth&accion=login');
            exit;
        } else {
            $_SESSION['error'] = 'Error al registrar el usuario. Intente nuevamente.';
            header('Location: index.php?modulo=auth&accion=registro');
            exit;
        }
    }
    
    /**
     * Cerrar sesion
     */
    public function logout() {
        session_destroy();
        header('Location: index.php?modulo=auth&accion=login');
        exit;
    }
    
    /**
     * Metodo por defecto
     */
    public function index() {
        $this->login();
    }
}
?>
