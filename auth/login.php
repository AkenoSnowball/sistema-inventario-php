<?php
session_start();
include("../config/conexion.php");

if (isset($_POST['login'])) {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // 1. Preparamos la consulta segura
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
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Inventario</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="card shadow-lg border-0">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
                <h3 class="fw-bold">Bienvenido</h3>
                <p class="text-muted">Ingresa tus credenciales</p>
            </div>

            <!-- Alerta de Error -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger py-2 text-center" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="correo" class="form-control" placeholder="nombre@correo.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="********" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary btn-lg">
                        Ingresar <i class="bi bi-arrow-right-short"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <p class="text-center mt-4 text-muted small">&copy; 2026 Sistema de Inventario</p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net"></script>
</body>
</html>
