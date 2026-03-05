<?php include 'includes/footer.php'; ?>

<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

include("config/conexion.php");
include("includes/header.php");  // TRAE EL DISEÑO DE header

// --- CONSULTAS PARA REPORTES ---

// 1. Calcular el Valor Total del Inventario
$res_valor = $conn->query("SELECT SUM(precio * stock) AS total_monetario FROM productos");
$datos_valor = $res_valor->fetch_assoc();
$total_dinero = $datos_valor['total_monetario'] ?? 0;

// 2. Contar total de productos distintos
$res_prod = $conn->query("SELECT COUNT(*) AS total_items FROM productos");
$datos_prod = $res_prod->fetch_assoc();
$total_items = $datos_prod['total_items'] ?? 0;

// 3. Productos con stock crítico (menos de 5)
$res_critico = $conn->query("SELECT COUNT(*) AS critico FROM productos WHERE stock < 5");
$datos_critico = $res_critico->fetch_assoc();
$total_critico = $datos_critico['critico'] ?? 0;
?>

<div class="container mt-4">
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="display-6">Resumen de Inventario</h2>
            <p class="text-muted">Estado financiero y operativo en tiempo real.</p>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Capital Invertido</h6>
                            <h2 class="mb-0">$<?= number_format($total_dinero, 2) ?></h2>
                        </div>
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Productos Registrados</h6>
                            <h2 class="mb-0"><?= $total_items ?></h2>
                        </div>
                        <i class="bi bi-box-seam fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card <?= ($total_critico > 0) ? 'bg-danger' : 'bg-success' ?> text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Stock Crítico (< 5)</h6>
                            <h2 class="mb-0"><?= $total_critico ?></h2>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 text-center">
        <h3>Accesos Rápidos</h3>
        <div class="col-md-4">
            <a href="productos/listar.php" class="btn btn-outline-dark w-100 py-3">
                <i class="bi bi-list-ul"></i> Gestionar Productos
            </a>
        </div>
        <div class="col-md-4">
            <a href="movimientos/entrada.php" class="btn btn-outline-success w-100 py-3">
                <i class="bi bi-plus-lg"></i> Registrar Entrada
            </a>
        </div>
        <div class="col-md-4">
            <a href="movimientos/salida.php" class="btn btn-outline-warning w-100 py-3">
                <i class="bi bi-dash-lg"></i> Registrar Salida
            </a>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>  // TRAE EL DISEÑO DE ABAJO