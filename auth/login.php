<?php
session_start();
include("../config/conexion.php");

if (isset($_POST['login'])) {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // 1. Preparamos la consulta
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // 2. Verificamos si el usuario existe
    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        // 3. Verificamos la contraseña con el hash
        if (password_verify($password, $usuario['contraseña'])) { 
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: ../index.php");
            exit();
        } else {
            // Error genérico por seguridad
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        // Error genérico si el correo no existe
        $error = "Usuario o contraseña incorrectos.";
    }
    $stmt->close();
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
