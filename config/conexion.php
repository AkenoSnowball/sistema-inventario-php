<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "bd_inventario";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configurar el conjunto de caracteres a UTF-8 para evitar errores con tildes
$conn->set_charset("utf8");
?>

