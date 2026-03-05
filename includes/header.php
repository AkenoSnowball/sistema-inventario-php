//
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/inventario/index.php">📦 Gestión PYME</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/inventario/productos/listar.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="/inventario/movimientos/entrada.php">Entradas</a></li>
                <li class="nav-item"><a class="nav-link" href="/inventario/movimientos/salida.php">Salidas</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="/inventario/auth/logout.php">Salir</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">