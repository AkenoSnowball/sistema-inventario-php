<?php
session_start();
// SEGURIDAD: Solo el Admin entra aquí
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Admin') {
    header("Location: ../index.php?error=acceso_denegado");
    exit();
}

include("../config/conexion.php");
include("../includes/header.php");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Gestión de Usuarios</h2>
    <a href="crear.php" class="btn btn-primary"><i class="bi bi-person-plus"></i> Nuevo Usuario</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $res = $conn->query("SELECT id, nombre, correo, rol FROM usuarios");
                while ($u = $res->fetch_assoc()): 
                ?>
                <tr>
                    <td><?= $u['nombre'] ?></td>
                    <td><?= $u['correo'] ?></td>
                    <td><span class="badge <?= ($u['rol'] == 'Admin') ? 'bg-danger' : 'bg-info text-dark' ?>"><?= $u['rol'] ?></span></td>
                    <td class="text-center">
                        <a href="eliminar.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Borrar usuario?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>