<?php
session_start();
// 1. Protección de ruta: Si no hay sesión, al login
if (!isset($_SESSION['usuario'])) { 
    header("Location: ../auth/login.php"); 
    exit(); 
}

include("../config/conexion.php");
include("../includes/header.php"); 
?>

<!-- 2. Navegación superior (Prueba) -->
<div class="mb-3">
    <a href="../movimientos/entrada.php" class="btn btn-sm btn-link">Entrada</a> |
    <a href="../movimientos/salida.php" class="btn btn-sm btn-link">Salida</a>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Inventario de Productos</h2>
    <a href="crear.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Producto
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $resultado = $conn->query("SELECT * FROM productos");
                    while ($p = $resultado->fetch_assoc()) { 
                    ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                        <td><span class="badge bg-light text-dark border"><?= $p['codigo'] ?></span></td>
                        <td>$<?= number_format($p['precio'], 2) ?></td>
                        <td>
                            <?php if($p['stock'] <= 5): ?>
                                <span class="badge bg-danger">Bajo: <?= $p['stock'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?= $p['stock'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="eliminar.php?id=<?= $p['id'] ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Eliminar este producto?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="../index.php" class="btn-outline-primary">Volver al Inicio</a>
</div>

<?php include("../includes/footer.php"); ?>
