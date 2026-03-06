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
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--bs-body-bg); /* Usa el fondo automático del tema */
    }
    .login-card {
        width: 100%;
        max-width: 420px;
        padding: 20px;
    }
    .card {
        border: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
    }
</style>

</head>
<body>

<div class="login-card">
    <!-- Añadimos 'bg-body-tertiary' para que la tarjeta contraste con el fondo oscuro -->
    <div class="card shadow-lg border-0 bg-body-tertiary">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <!-- Un icono más llamativo -->
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                    <i class="bi bi-shield-lock text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h3 class="fw-bold">Bienvenido</h3>
                <p class="text-muted">Ingresa al Sistema de Inventario</p>
            </div>

            <!-- Alerta de Error corregida -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div><?= $error ?></div>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light-subtle border-end-0">
                            <i class="bi bi-envelope text-muted"></i>
                        </span>
                        <input type="email" name="correo" class="form-control border-start-0 ps-0" placeholder="admin@correo.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light-subtle border-end-0">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="********" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary btn-lg shadow-sm">
                        Ingresar <i class="bi bi-box-arrow-in-right ms-2"></i>
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
