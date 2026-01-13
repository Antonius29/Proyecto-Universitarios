<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <div class="container">

        <h1><b>GESTIÓN DE EMPLEADOS</b></h1>

        <?php
        if (isset($_GET['success'])) {
            echo "<div class='alert alert-success'><b>Empleado registrado exitosamente.</b></div>";
        }

        if (isset($_GET['deleted'])) {
            echo "<div class='alert alert-info'><b>Empleado eliminado correctamente.</b></div>";
        }
        ?>

        <div class="card">
            <h3><b>Registrar Empleado</b></h3>
            <form action="index.php?controlador=empleado&accion=guardar" method="POST">
                <div class="form-group">
                    <label><b>Nombre Completo</b></label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label><b>Cargo</b></label>
                    <input type="text" name="cargo" class="form-control" required>
                </div>

                <div class="form-group">
                    <label><b>Salario</b></label>
                    <input type="number" step="0.01" name="salario" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block"><b>Guardar</b></button>
            </form>
        </div>

        <div class="card">
            <h3><b>Lista de Empleados</b></h3>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Salario</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (!empty($empleados)) {
                            foreach ($empleados as $emp) {
                                echo "<tr>";
                                echo "<td>{$emp['id']}</td>";
                                echo "<td>{$emp['nombre']}</td>";
                                echo "<td>{$emp['cargo']}</td>";
                                echo "<td>$" . number_format($emp['salario'], 2) . "</td>";
                                echo "<td>
                                <a href='index.php?controlador=empleado&accion=eliminar&id={$emp['id']}'
                                class='btn btn-danger btn-sm'onclick=\"return confirm('¿Eliminar empleado?')\"><b>Eliminar</b></a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>";
                            echo "<td>No hay empleados</td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "</tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <footer>
        <small>&copy; 2026 Sistema de Gestión de Empleados. Todos los derechos reservados.</small>
    </footer>
</body>
</html>