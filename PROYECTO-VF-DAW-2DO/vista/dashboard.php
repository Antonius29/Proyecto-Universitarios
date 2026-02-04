<?php 
$titulo = "Dashboard";
include 'vista/layout/header.php'; 
?>

    <div class="container">
        <div class="page-header">
            <div>
                <h1>Panel de Control</h1>
                <p>Bienvenido al Sistema de Gestion de Inventario</p>
            </div>
        </div>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <h3><i class="bi bi-people"></i> Total Clientes</h3>
                <div class="stat-number"><?php echo $estadisticas['total_clientes']; ?></div>
            </div>

            <div class="stat-card">
                <h3><i class="bi bi-person-badge"></i> Usuarios Activos</h3>
                <div class="stat-number"><?php echo $estadisticas['usuarios_activos']; ?></div>
            </div>

            <div class="stat-card">
                <h3><i class="bi bi-truck"></i> Proveedores</h3>
                <div class="stat-number"><?php echo $estadisticas['total_proveedores']; ?></div>
            </div>

            <div class="stat-card">
                <h3><i class="bi bi-box"></i> Productos en Stock</h3>
                <div class="stat-number"><?php echo $estadisticas['productos_stock']; ?></div>
            </div>


        </div>

        <div class="card">
            <h2 class="section-title"><i class="bi bi-lightning"></i> Acciones Rapidas</h2>
            <div class="action-buttons" style="gap: 15px; flex-wrap: wrap;">
                <a href="index.php?modulo=clientes&accion=crear" class="btn btn-primary"><i class="bi bi-person-plus"></i> Agregar Cliente</a>
                <a href="index.php?modulo=usuarios&accion=crear" class="btn btn-primary"><i class="bi bi-person-add"></i> Agregar Usuario</a>
                <a href="index.php?modulo=proveedores&accion=crear" class="btn btn-primary"><i class="bi bi-truck"></i> Agregar Proveedor</a>
                <a href="index.php?modulo=inventario&accion=crear" class="btn btn-primary"><i class="bi bi-box-seam"></i> Agregar Producto</a>
                <a href="index.php?modulo=pedidos&accion=crear" class="btn btn-primary"><i class="bi bi-cart-plus"></i> Agregar Pedido</a>
            </div>
        </div>
    </div>

<?php include 'vista/layout/footer.php'; ?>
