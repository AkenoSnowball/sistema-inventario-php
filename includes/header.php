
<!DOCTYPE html>
<html lang="es">
<head>
    <script>
    // Esto se ejecuta antes que cualquier otra cosa
    (function() {
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
    })();
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

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
    
                <!-- Interruptor de Tema -->
                <li class="nav-item d-flex align-items-center me-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                        <label class="form-check-label text-white-50" for="themeToggle">
                            <i class="bi bi-moon-stars-fill"></i>
                        </label>
                    </div>
                </li>

    <li class="nav-item">
        <a class="nav-link text-danger" href="/inventario/auth/logout.php">Salir</a>
    </li>
</ul>

        </div>
    </div>
</nav>
<div class="container">