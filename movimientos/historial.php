<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: ../auth/login.php"); exit(); }

include("../config/conexion.php");
include("../includes/header.php");

// Consulta avanzada para unir tablas
$sql = "SELECT m.fecha, p.nombre as producto, u.nombre as usuario, m.tipo, m.cantidad 
        FROM movimientos m
        JOIN productos p ON m.producto_id = p.id
        JOIN usuarios u ON m.usuario_id = u.id
        ORDER BY m.fecha DESC";
$resultado = $conn->query($sql);
?>

<div class="container">
    <h2 class="mb-4"><i class="bi bi-clock-history"></i> Historial de Actividad</h2>
    
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Usuario</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
                        <td><i class="bi bi-person-circle"></i> <?= $row['usuario'] ?></td>
                        <td><strong><?= $row['producto'] ?></strong></td>
                        <td>
                            <span class="badge <?= ($row['tipo'] == 'entrada') ? 'bg-success' : 'bg-danger' ?>">
                                <?= strtoupper($row['tipo']) ?>
                            </span>
                        </td>
                        <td><?= $row['cantidad'] ?> unidades</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>