<?php
session_start();
include("../config/conexion.php");

if (isset($_POST['login'])) {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        // Compara la clave ingresada con el hash guardado en la BD
if (password_verify($password, $usuario['contraseña'])) { 
    $_SESSION['usuario'] = $usuario['nombre'];
    $_SESSION['rol'] = $usuario['rol'];
    header("Location: ../index.php");
    exit();
} else {
    $error = "Contraseña incorrecta";
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventario</title>
</head>
<body>

<h2>Iniciar sesión</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <label>Correo:</label><br>
    <input type="email" name="correo" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Ingresar</button>
</form>

</body>
</html>
