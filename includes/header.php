
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

    <style>
        /* Estilos específicos para el nuevo logo */
        .logo-image {
            height: 32px; 
            width: auto;
            object-fit: contain;
        }
        .navbar-brand span {
            font-weight: 600;
            font-size: 1.15rem;
        }
        /* Efecto para que el logo resalte en modo oscuro */
        .navbar-dark .logo-image {
            filter: drop-shadow(0px 0px 1px white);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <!-- SECCIÓN MODIFICADA: Reemplazo del texto plano por el Logo + Texto -->
        <a class="navbar-brand d-flex align-items-center" href="/inventario/index.php">📦 Gestión PYME</a>
            <img src="/inventario/assets/img/logo_invento.png" alt="Logo" class="logo-image me-2">
            <span>INVENTO</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center"> <!-- Añadido align-items-center -->
                <li class="nav-item"><a class="nav-link" href="/inventario/productos/listar.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="/inventario/movimientos/entrada.php">Entradas</a></li>
                <li class="nav-item"><a class="nav-link" href="/inventario/movimientos/salida.php">Salidas</a></li>
            <!-- INSERCCION DEL HISTORIAL -->
                <li class="nav-item">
                    <a class="nav-link" href="/inventario/movimientos/historial.php">
                        <i class="bi bi-journal-text"></i> Historial
                    </a>
                </li>
                <!-- SOLO ADMIN VE ESTO -->
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/inventario/usuarios/listar.php">
                            <i class="bi bi-people-fill"></i> Usuarios
                        </a>
                    </li>
                <?php endif; ?>
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