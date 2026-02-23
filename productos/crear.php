<?php
session_start();
include("../config/conexion.php");

if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO productos (nombre, codigo, precio)
            VALUES ('$nombre', '$codigo', '$precio')";

    if ($conn->query($sql)) {
        header("Location: listar.php");
        exit();
    } else {
        $error = "Error al guardar producto";
    }
}
?>

<h2>Registrar producto</h2>

<?php if (isset($error)) echo $error; ?>

<form method="POST">
    Nombre:<br>
    <input type="text" name="nombre" required><br><br>

    Código:<br>
    <input type="text" name="codigo" required><br><br>

    Precio:<br>
    <input type="number" step="0.01" name="precio" required><br><br>

    <button name="guardar">Guardar</button>
</form>

<a href="listar.php">Volver</a>
