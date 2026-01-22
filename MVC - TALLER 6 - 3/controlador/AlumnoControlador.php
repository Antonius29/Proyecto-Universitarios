<?php
require_once __DIR__ . '/../modelo/AlumnoModelo.php';

class AlumnoControlador {

    public function listar()
    {
        // Obtener los parámetros de búsqueda desde GET
        $tipo_busqueda = $_GET['tipo_busqueda'] ?? 'todos';
        $valor_busqueda = $_GET['valor_busqueda'] ?? '';

        //creamos el objeto del modelo
        $alumnoModelo = new AlumnoModelo();

        if ($tipo_busqueda === 'nombre' && $valor_busqueda) {
            // Si se proporcionó un nombre, buscamos alumnos por ese nombre
            $alumnos = $alumnoModelo->buscarPorNombre($valor_busqueda);
        } elseif ($tipo_busqueda === 'apellido' && $valor_busqueda) {
            // Si se proporcionó un apellido, buscamos alumnos por ese apellido
            $alumnos = $alumnoModelo->buscarPorApellido($valor_busqueda);
        } else {
            // Si no se proporcionó un nombre, obtenemos todos los alumnos
            $alumnos = $alumnoModelo->obtenerTodos();
        }

       
           if (!$alumnos) {
            $alumnos = [];
        }

        $cantidad = count($alumnos);
        

       require_once __DIR__ . '/../vista/listadoAlumnos.php';
    }

    public function formulario()
    {
        require_once __DIR__ . '/../vista/formularioAlumno.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?accion=nuevo');
            exit;
        }

        // Obtener datos del formulario
        $cedula = trim($_POST['cedula'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
        $curso = trim($_POST['curso'] ?? '');
        $estado = trim($_POST['estado'] ?? '');

        // Validar campos requeridos
        if (empty($cedula) || empty($nombre) || empty($apellido) || empty($correo) || empty($fecha_nacimiento) || empty($curso) || empty($estado)) {
            $error = 'Todos los campos son requeridos';
            require_once __DIR__ . '/../vista/formularioAlumno.php';
            return;
        }

        // Validar formato de cédula
        if (!preg_match('/^\d{10}$/', $cedula)) {
            $error = 'La cédula debe contener exactamente 10 dígitos';
            require_once __DIR__ . '/../vista/formularioAlumno.php';
            return;
        }

        // Validar formato de correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = 'El correo no es válido';
            require_once __DIR__ . '/../vista/formularioAlumno.php';
            return;
        }

        // Crear instancia del modelo y guardar
        $alumnoModelo = new AlumnoModelo();
        $resultado = $alumnoModelo->guardar($cedula, $nombre, $apellido, $correo, $telefono, $fecha_nacimiento, $curso, $estado);

        if ($resultado['success']) {
            $mensaje = $resultado['mensaje'];
            require_once __DIR__ . '/../vista/formularioAlumno.php';
        } else {
            $error = $resultado['mensaje'];
            require_once __DIR__ . '/../vista/formularioAlumno.php';
        }
    }
}
?>