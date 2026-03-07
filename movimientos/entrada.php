<?php
session_start();
include("../config/conexion.php");
// 1. Verificación de sesión
if (!isset($_SESSION['usuario'])) { 
    header("Location: ../auth/login.php"); 
    exit(); 
}

// 2. Lógica para registrar la entrada (Procesar el formulario)
if (isset($_POST['registrar'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $user_id = $_SESSION['user_id']; // Capturamos quién hace la entrada
    $tipo = 'entrada';
    // Usamos sentencias preparadas para seguridad
    // Registrar movimiento
    $stmt1 = $conn->prepare("INSERT INTO movimientos (producto_id, usuario_id, tipo, cantidad) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("iisi", $producto_id, $user_id, $tipo, $cantidad);
        
if ($stmt1->execute()) {

    // Aumentar stock en la tabla productos
    $stmt2 = $conn->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
    $stmt2->bind_param("ii", $cantidad, $producto_id);
    $stmt2->execute();

    header("Location: ../productos/listar.php?msg=entrada_ok");
    exit();
    }
}

// 3. Obtener productos para el menú desplegable
$productos = $conn->query("SELECT * FROM productos");

include("../includes/header.php");
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-arrow-down-circle"></i> Registrar Entrada</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Producto</label>
                        <select name="producto_id" class="form-select" required>
                            <option value="">Seleccione un producto...</option>
                            <?php while ($p = $productos->fetch_assoc()) { ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= htmlspecialchars($p['nombre']) ?> (Stock actual: <?= $p['stock'] ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad a ingresar</label>
                        <input type="number" name="cantidad" class="form-control" min="1" placeholder="Ej: 10" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button name="registrar" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Guardar Entrada
                        </button>
                        <a href="../productos/listar.php" class="btn btn-light border">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
