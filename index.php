<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
</head>
<body>

<h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
<p>Rol: <?php echo $_SESSION['rol']; ?></p>

<a href="auth/logout.php">Cerrar sesión</a>

</body>
</html>
