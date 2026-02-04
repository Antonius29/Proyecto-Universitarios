<?php 
$titulo = "Lista de Usuarios";
include 'vista/layout/header.php'; 
?>

    <div class="container">
        <div class="page-header">
            <h1><i class="bi bi-person-badge"></i> Lista de Usuarios</h1>
            <a href="index.php?modulo=usuarios&accion=crear" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Agregar Usuario</a>
        </div>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="search-bar">
            <form method="get" action="index.php" id="searchForm">
                <input type="hidden" name="modulo" value="usuarios">
                <input type="hidden" name="accion" value="lista">
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="buscar" placeholder="Buscar usuarios por nombre, email o rol..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>" style="flex: 1;">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                    <a href="index.php?modulo=usuarios&accion=lista" class="btn btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Limpiar</a>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--color-gray-medium);">No se encontraron usuarios</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td>U<?php echo str_pad($usuario['numero'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td>
                                    <span class="badge <?php echo $usuario['rol'] == 'administrador' ? 'badge-danger' : 'badge-info'; ?>">
                                        <?php echo ucfirst($usuario['rol']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                                <td>
                                    <span class="badge <?php echo $usuario['estado'] == 'activo' ? 'badge-success' : 'badge-warning'; ?>">
                                        <?php echo ucfirst($usuario['estado']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?modulo=usuarios&accion=detalle&id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> Ver</a>
                                        <a href="index.php?modulo=usuarios&accion=editar&id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                                        <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                            <a href="#" onclick="abrirConfirmModal('index.php?modulo=usuarios&accion=eliminar&id=<?php echo $usuario['id']; ?>', '¿Está seguro de que desea eliminar este usuario?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Eliminar</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include 'vista/layout/footer.php'; ?>
