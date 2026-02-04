<?php 
$titulo = "Lista de Pedidos";
include 'vista/layout/header.php'; 
?>

    <div class="container">
        <div class="page-header">
            <h1><i class="bi bi-cart"></i> Lista de Pedidos</h1>
            <a href="index.php?modulo=pedidos&accion=crear" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Crear Pedido</a>
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
                <input type="hidden" name="modulo" value="pedidos">
                <input type="hidden" name="accion" value="lista">
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="buscar" placeholder="Buscar pedidos por cliente, fecha o estado..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>" style="flex: 1;">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                    <a href="index.php?modulo=pedidos&accion=lista" class="btn btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Limpiar</a>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Método de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pedidos)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--color-gray-medium);">No se encontraron pedidos</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pedido['numero_pedido']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['cliente_nombre'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($pedido['fecha_pedido']); ?></td>
                                <td>
                                    <?php 
                                        $estado = $pedido['estado'];
                                        $clases = [
                                            'pendiente' => 'badge-warning',
                                            'proceso' => 'badge-info',
                                            'completado' => 'badge-success',
                                            'cancelado' => 'badge-danger'
                                        ];
                                        $clase = $clases[$estado] ?? 'badge-secondary';
                                    ?>
                                    <span class="badge <?php echo $clase; ?>"><?php echo ucfirst($estado); ?></span>
                                </td>
                                <td style="font-weight: 700; color: var(--color-primary);">$<?php echo number_format($pedido['total'], 2); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($pedido['metodo_pago'])); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?modulo=pedidos&accion=detalle&id=<?php echo $pedido['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> Ver</a>
                                        <a href="index.php?modulo=pedidos&accion=editar&id=<?php echo $pedido['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                                        <a href="#" onclick="abrirConfirmModal('index.php?modulo=pedidos&accion=eliminar&id=<?php echo $pedido['id']; ?>', '¿Está seguro de que desea eliminar este pedido?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Eliminar</a>
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
