<?php
header("Content-Type: application/json");
include("../config/conexion.php");

$metodo = $_SERVER['REQUEST_METHOD']; // Detecta GET, POST, PUT o DELETE
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch($metodo) {
    case 'GET': // CONSULTAR
        if ($id) {
            $sql = "SELECT * FROM productos WHERE id = $id";
            $res = $conn->query($sql);
            echo json_encode($res->fetch_assoc());
        } else {
            $sql = "SELECT * FROM productos";
            $res = $conn->query($sql);
            echo json_encode($res->fetch_all(MYSQLI_ASSOC));
        }
        break;

    case 'POST': // REGISTRAR
        $datos = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("INSERT INTO productos (nombre, codigo, precio, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $datos['nombre'], $datos['codigo'], $datos['precio'], $datos['stock']);
        if($stmt->execute()) echo json_encode(["msj" => "Producto creado"]);
        break;

    case 'PUT': // ACTUALIZAR
        $datos = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, stock=? WHERE id=?");
        $stmt->bind_param("sdii", $datos['nombre'], $datos['precio'], $datos['stock'], $id);
        if($stmt->execute()) echo json_encode(["msj" => "Producto actualizado"]);
        break;

    case 'DELETE': // ELIMINAR
        if ($id) {
            $conn->query("DELETE FROM productos WHERE id = $id");
            echo json_encode(["msj" => "Producto eliminado"]);
        }
        break;
}