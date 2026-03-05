<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}
include 'includes/header.php'; // TRAE EL DISEÑO DE header
?>

<div class="text-center py-5">
    <h1>Bienvenido, <span class="text-primary"><?= $_SESSION['usuario'] ?></span></h1>
    <p class="lead">Rol: <span class="badge bg-secondary"><?= $_SESSION['rol'] ?></span></p>
    <hr>
    <div class="row mt-4">
        </div>
</div>

<?php include 'includes/footer.php'; // TRAE EL DISEÑO DE ABAJO ?>