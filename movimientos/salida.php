<?php
session_start();
// 1. Verificación de sesión
if (!isset($_SESSION['usuario'])) { 
    header("Location: ../auth/login.php"); 
    exit(); 
}

include("../config/conexion.php");

// 2. Lógica para registrar la salida
if (isset($_POST['registrar'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Consultamos el stock actual de forma segura
    $stmt_check = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
    $stmt_check->bind_param("i", $producto_id);
    $stmt_check->execute();
    $resultado = $stmt_check->get_result();
    $producto = $resultado->fetch_assoc();

    // Verificamos si hay suficiente stock
    if ($producto['stock'] >= $cantidad) {
        
        // Registrar el movimiento de salida
        $stmt_ins = $conn->prepare("INSERT INTO movimientos (producto_id, tipo, cantidad) VALUES (?, 'salida', ?)");
        $stmt_ins->bind_param("ii", $producto_id, $cantidad);
        $stmt_ins->execute();

        // Restar el stock en la tabla productos
        $stmt_upd = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $stmt_upd->bind_param("ii", $cantidad, $producto_id);
        $stmt_upd->execute();

        header("Location: ../productos/listar.php");
        exit();
    } else {
        $error = "¡Error! Stock insuficiente. Solo quedan " . $producto['stock'] . " unidades.";
    }
}

// 3. Obtener productos para el select
$productos = $conn->query("SELECT * FROM productos");

include("../includes/header.php");
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <!-- Header en Rojo para diferenciar que es una SALIDA -->
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0"><i class="bi bi-arrow-up-circle"></i> Registrar Salida</h4>
            </div>
            <div class="card-body">
                
                <!-- Alerta de error si el stock no alcanza -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Producto</label>
                        <select name="producto_id" class="form-select" required>
                            <option value="">Seleccione un producto...</option>
                            <?php while ($p = $productos->fetch_assoc()) { ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= htmlspecialchars($p['nombre']) ?> (Disponible: <?= $p['stock'] ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad a retirar</label>
                        <input type="number" name="cantidad" class="form-control" min="1" placeholder="Ej: 5" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button name="registrar" class="btn btn-danger">
                            <i class="bi bi-dash-circle"></i> Confirmar Salida
                        </button>
                        <a href="../productos/listar.php" class="btn btn-light border">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
