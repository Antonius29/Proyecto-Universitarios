<?php

// Obtener parámetros de la URL
$controlador = $_GET['controlador'] ?? 'empleado';
$accion = $_GET['accion'] ?? 'mostrar';

// Enrutador simple
switch ($controlador) {
    case 'empleado':
        require_once __DIR__ . '/controlador/EmpleadoControlador.php';
        $empleadoControlador = new EmpleadoControlador();
        
        switch ($accion) {
            case 'mostrar':
                $empleadoControlador->mostrar();
                break;
            
            case 'guardar':
                $empleadoControlador->guardar();
                break;
            
            case 'eliminar':
                $empleadoControlador->eliminar();
                break;
            
            default:
                $empleadoControlador->mostrar();
                break;
        }
        break;
    
    default:
        require_once __DIR__ . '/controlador/EmpleadoControlador.php';
        $empleadoControlador = new EmpleadoControlador();
        $empleadoControlador->mostrar();
        break;
}

?>
