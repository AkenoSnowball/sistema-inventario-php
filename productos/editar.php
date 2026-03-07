<?php
session_start();

// 1. Verificar si está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

// 2. Verificar si es Administrador
if ($_SESSION['rol'] !== 'Admin') {
    header("Location: ../index.php?error=acceso_denegado");
    exit();
}

// 3. Conexión a la base de datos
include("../config/conexion.php");

// Verificamos que el ID exista
if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id = $_GET['id'];

// 4. Procesar la actualización (Si se envió el formulario)
if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];

    // Usamos Prepared Statements por seguridad
    $stmt = $conn->prepare("UPDATE productos SET nombre=?, codigo=?, precio=? WHERE id=?");
    $stmt->bind_param("ssdi", $nombre, $codigo, $precio, $id);

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Error al actualizar el producto.";
    }
    $stmt->close();
}

// 5. Obtener los datos actuales del producto para rellenar el formulario
$stmt_busqueda = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt_busqueda->bind_param("i", $id);
$stmt_busqueda->execute();
$producto = $stmt_busqueda->get_result()->fetch_assoc();

if (!$producto) {
    echo "Producto no encontrado.";
    exit();
}
?>

<h2>Editar producto</h2>

<form method="POST">
    Nombre:<br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required><br><br>

    Código:<br>
    <input type="text" name="codigo" value="<?= htmlspecialchars($producto['codigo']) ?>" required><br><br>

    Precio:<br>
    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required><br><br>

    <button name="actualizar">Actualizar</button>
</form>

<a href="listar.php">Volver</a>
