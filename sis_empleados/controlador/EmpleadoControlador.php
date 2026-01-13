<?php
require_once __DIR__ . '/../modelo/EmpleadoModelo.php';

class EmpleadoControlador
{
    public function mostrar()
    {
        $modelo = new EmpleadoModelo();
        $empleados = $modelo->obtenerTodos();
        require_once __DIR__ . '/../vista/empleados.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'cargo' => trim($_POST['cargo'] ?? ''),
                'salario' => floatval($_POST['salario'] ?? 0)
            ];

            $modelo = new EmpleadoModelo();
            $resultado = $modelo->insertar($datos);

            if ($resultado) {
                header("Location: index.php?controlador=empleado&accion=mostrar&success=1");
            } else {
                header("Location: index.php?controlador=empleado&accion=mostrar&error=1");
            }
            exit;
        }
    }

    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $modelo = new EmpleadoModelo();
            $modelo->eliminar(intval($_GET['id']));
            header("Location: index.php?controlador=empleado&accion=mostrar&deleted=1");
            exit;
        }
    }
}
?>
