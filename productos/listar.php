<a href="../movimientos/entrada.php">Entrada</a> |
<a href="../movimientos/salida.php">Salida</a>
<br><br>

<?php
session_start();
include("../config/conexion.php");

$resultado = $conn->query("SELECT * FROM productos");
?>

<h2>Lista de productos</h2>

<a href="crear.php">Nuevo producto</a>
<br><br>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Código</th>
    <th>Precio</th>
    <th>Stock</th>
    <th>Acciones</th>
</tr>

<?php while ($p = $resultado->fetch_assoc()) { ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['nombre'] ?></td>
    <td><?= $p['codigo'] ?></td>
    <td><?= $p['precio'] ?></td>
    <td><?= $p['stock'] ?></td>
    <td>
        <a href="editar.php?id=<?= $p['id'] ?>">Editar</a>
        |
        <a href="eliminar.php?id=<?= $p['id'] ?>"
           onclick="return confirm('¿Eliminar producto?')">
           Eliminar
        </a>
    </td>
</tr>
<?php } ?>
</table>

<a href="../index.php">Inicio</a>
