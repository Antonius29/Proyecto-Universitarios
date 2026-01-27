<?php
session_start();

$accion = isset($_GET['accion']) ? $_GET['accion'] : 'inicio';

switch ($accion) {
    case 'inicio':
        include 'vista/inicio.php';
        break;
    
    case 'login':
        include 'vista/login.php';
        break;
    
    case 'procesarLogin':
        require_once __DIR__ . '/controlador/UsuarioControlador.php';
        $controlador = new UsuarioControlador();
        $controlador->procesarLogin($_POST['usuario'], $_POST['clave']);
        break;
    
    case 'menu':
        include 'vista/menu.php';
        break;
    
    case 'consultarAlumno':
        include 'vista/alumno/consultar.php';
        break;
    
    case 'registrarAlumno':
        include 'vista/alumno/registrar.php';
        break;
    
    case 'guardarAlumno':
        require_once __DIR__ . '/dao/AlumnoDao.php';
        require_once __DIR__ . '/modelo/Alumno.php';
        
        try {
            $alumno = new Alumno();
            $alumno->cedula = $_POST['cedula'] ?? '';
            $alumno->nombre = $_POST['nombre'] ?? '';
            $alumno->apellido = $_POST['apellido'] ?? '';
            $alumno->correo = $_POST['correo'] ?? '';
            $alumno->telefono = $_POST['telefono'] ?? '';
            $alumno->fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $alumno->curso = $_POST['curso'] ?? '';
            $alumno->estado = $_POST['estado'] ?? 'Activo';
            
            $alumnoDao = new AlumnoDao();
            $resultado = $alumnoDao->insertar($alumno);
            
            if ($resultado) {
                header('Location: index.php?accion=consultarAlumno&exito=1');
            } else {
                header('Location: index.php?accion=registrarAlumno&error=1');
            }
        } catch (Exception $e) {
            header('Location: index.php?accion=registrarAlumno&error=1');
        }
        exit();
        break;
    
    case 'editarAlumno':
        include 'vista/alumno/editar.php';
        break;
    
    case 'actualizarAlumno':
        require_once __DIR__ . '/dao/AlumnoDao.php';
        require_once __DIR__ . '/modelo/Alumno.php';
        
        try {
            $alumno = new Alumno();
            $alumno->id = $_POST['id'] ?? '';
            $alumno->cedula = $_POST['cedula'] ?? '';
            $alumno->nombre = $_POST['nombre'] ?? '';
            $alumno->apellido = $_POST['apellido'] ?? '';
            $alumno->correo = $_POST['correo'] ?? '';
            $alumno->telefono = $_POST['telefono'] ?? '';
            $alumno->fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $alumno->curso = $_POST['curso'] ?? '';
            $alumno->estado = $_POST['estado'] ?? 'Activo';
            
            $alumnoDao = new AlumnoDao();
            $resultado = $alumnoDao->actualizar($alumno);
            
            if ($resultado) {
                header('Location: index.php?accion=consultarAlumno&exito=1');
            } else {
                header('Location: index.php?accion=editarAlumno&id=' . $_POST['id'] . '&error=1');
            }
        } catch (Exception $e) {
            header('Location: index.php?accion=editarAlumno&id=' . $_POST['id'] . '&error=1');
        }
        exit();
        break;
    
    case 'eliminarAlumno':
        require_once __DIR__ . '/dao/AlumnoDao.php';
        
        try {
            $id = $_GET['id'] ?? null;
            
            if ($id) {
                $alumnoDao = new AlumnoDao();
                $resultado = $alumnoDao->eliminar($id);
                
                if ($resultado) {
                    header('Location: index.php?accion=consultarAlumno&exito=1');
                } else {
                    header('Location: index.php?accion=consultarAlumno&error=1');
                }
            } else {
                header('Location: index.php?accion=consultarAlumno&error=1');
            }
        } catch (Exception $e) {
            header('Location: index.php?accion=consultarAlumno&error=1');
        }
        exit();
        break;
    
    default:
        include 'vista/inicio.php';
        break;
}
?>