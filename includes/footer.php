</div> <footer class="text-center py-4 text-muted mt-5">
    <p>&copy; 2026 - Sistema de Inventario SENA</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ... código de cambio de tema ... -->
<script>
    // 1. Seleccionamos los elementos
    const themeToggle = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;

    // 2. Función para aplicar el tema
    const applyTheme = (theme) => {
        htmlElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
        if (themeToggle) themeToggle.checked = (theme === 'dark');
    };

    // 3. Al cargar la página: Leer preferencia guardada
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    // 4. Escuchar el cambio y RECARGAR
    if (themeToggle) {
        themeToggle.addEventListener('change', () => {
            const newTheme = themeToggle.checked ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            
            // Recarga automática para aplicar cambios globales
            location.reload();
        });
    }
</script>

</body>
</html>

</body>
</html>