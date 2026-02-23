<?php
session_start();
include("../config/conexion.php");

$productos = $conn->query("SELECT * FROM productos");

if (isset($_POST['registrar'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Registrar movimiento
    $conn->query("INSERT INTO movimientos (producto_id, tipo, cantidad)
                  VALUES ($producto_id, 'entrada', $cantidad)");

    // Aumentar stock
    $conn->query("UPDATE productos 
                  SET stock = stock + $cantidad 
                  WHERE id = $producto_id");

    header("Location: ../productos/listar.php");
    exit();
}
?>

<h2>Entrada de Inventario</h2>

<form method="POST">
    Producto:<br>
    <select name="producto_id" required>
        <?php while ($p = $productos->fetch_assoc()) { ?>
            <option value="<?= $p['id'] ?>">
                <?= $p['nombre'] ?>
            </option>
        <?php } ?>
    </select><br><br>

    Cantidad:<br>
    <input type="number" name="cantidad" min="1" required><br><br>

    <button name="registrar">Registrar Entrada</button>
</form>

<a href="../productos/listar.php">Volver</a>
