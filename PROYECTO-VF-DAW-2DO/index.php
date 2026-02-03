<?php
/**
 * SISTEMA DE GESTION DE INVENTARIO
 * Archivo principal - Router
 */

session_start();

// Si accede sin parámetros y ya está autenticado, ir al dashboard
if (!isset($_GET['modulo']) && !isset($_GET['accion']) && isset($_SESSION['usuario_id'])) {
    header('Location: index.php?modulo=dashboard&accion=index');
    exit;
}

// Obtener la accion solicitada
$modulo = isset($_GET['modulo']) ? $_GET['modulo'] : 'auth';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'login';

// Rutas publicas (no requieren autenticacion)
$rutasPublicas = [
    'auth' => ['login', 'registro', 'procesar_login', 'procesar_registro', 'logout']
];

// Verificar si la ruta es publica
$esRutaPublica = isset($rutasPublicas[$modulo]) && in_array($accion, $rutasPublicas[$modulo]);

// Verificar autenticacion para rutas protegidas
if (!$esRutaPublica && !isset($_SESSION['usuario_id'])) {
    header('Location: index.php?modulo=auth&accion=login');
    exit;
}

// Cargar el controlador correspondiente
switch ($modulo) {
    case 'auth':
        require_once 'controlador/AuthControlador.php';
        $controlador = new AuthControlador();
        break;
    
    case 'dashboard':
        require_once 'controlador/DashboardControlador.php';
        $controlador = new DashboardControlador();
        break;
    
    case 'clientes':
        require_once 'controlador/ClienteControlador.php';
        $controlador = new ClienteControlador();
        break;
    
    case 'usuarios':
        require_once 'controlador/UsuarioControlador.php';
        $controlador = new UsuarioControlador();
        break;
    
    case 'proveedores':
        require_once 'controlador/ProveedorControlador.php';
        $controlador = new ProveedorControlador();
        break;
    
    case 'inventario':
        require_once 'controlador/ProductoControlador.php';
        $controlador = new ProductoControlador();
        break;
    
    case 'pedidos':
        require_once 'controlador/PedidoControlador.php';
        $controlador = new PedidoControlador();
        break;
    
    default:
        header('Location: index.php?modulo=auth&accion=login');
        exit;
}

// Ejecutar la accion
if (method_exists($controlador, $accion)) {
    $controlador->$accion();
} else {
    // Accion por defecto del controlador
    $controlador->index();
}
?>
