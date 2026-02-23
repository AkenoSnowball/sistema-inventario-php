<?php
session_start();
include("../config/conexion.php");

$id = $_GET['id'];

if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];

    $conn->query("UPDATE productos 
                  SET nombre='$nombre', codigo='$codigo', precio='$precio'
                  WHERE id=$id");

    header("Location: listar.php");
    exit();
}

$producto = $conn->query("SELECT * FROM productos WHERE id=$id")->fetch_assoc();
?>

<h2>Editar producto</h2>

<form method="POST">
    Nombre:<br>
    <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" required><br><br>

    Código:<br>
    <input type="text" name="codigo" value="<?= $producto['codigo'] ?>" required><br><br>

    Precio:<br>
    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required><br><br>

    <button name="actualizar">Actualizar</button>
</form>

<a href="listar.php">Volver</a>
