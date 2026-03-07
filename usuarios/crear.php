<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Admin') { header("Location: ../index.php"); exit(); }

include("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    // 🔐 ENCRIPTAMOS LA CONTRASEÑA ANTES DE GUARDAR
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $password, $rol);
    
    if ($stmt->execute()) {
        header("Location: listar.php?msg=usuario_creado");
    }
}

include("../includes/header.php");
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center"><h4>Nuevo Usuario</h4></div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña Temporal</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Asignar Rol</label>
                        <select name="rol" class="form-select">
                            <option value="Empleado">Empleado</option>
                            <option value="Admin">Administrador</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100">Crear Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>