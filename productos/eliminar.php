<?php
session_start();
include("../config/conexion.php");

// 1. Verificamos que el ID realmente llegue por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 2. Preparamos la eliminación segura
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indica que el ID es un entero (integer)

    // 3. Ejecutamos y redireccionamos
    if ($stmt->execute()) {
        header("Location: listar.php");
        exit(); // Es vital usar exit() tras un header para detener el script
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
