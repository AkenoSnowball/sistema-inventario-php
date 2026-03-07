<?php
session_start();

// 1. Verificar si está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

// 2. Verificar si es Administrador
if ($_SESSION['rol'] !== 'Admin') {
    // Si no es admin, lo mandamos al index con un mensaje de error
    header("Location: ../index.php?error=acceso_denegado");
    exit();
}

// 3. Si pasó las validaciones, incluimos la conexión
include("../config/conexion.php");

// 4. Verificamos que el ID realmente llegue por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparamos la eliminación segura
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indica que el ID es un entero

    // Ejecutamos y redireccionamos
    if ($stmt->execute()) {
        header("Location: listar.php");
        exit(); 
    } else {
        echo "Error al intentar eliminar el registro.";
    }

    $stmt->close();
} else {
    // Si no hay ID, volvemos a la lista
    header("Location: listar.php");
    exit();
}
?>
