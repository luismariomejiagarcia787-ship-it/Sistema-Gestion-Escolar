// Sistema Gestión Escolar - JS principal.
//
// NOTA DE CORRECCIÓN: este archivo antes empezaba con `import './bootstrap'`,
// sintaxis de módulo ES que un navegador NO puede ejecutar cuando el script
// se carga como <script src="..."> normal (sin type="module"). Además, el
// archivo "bootstrap.js" al que apuntaba el import nunca existió dentro de
// public/, solo en resources/js/ (fuera del docroot, inaccesible por HTTP).
// El resultado era un SyntaxError inmediato que impedía la ejecución de TODO
// el script: no se registraba el confirm() de borrado, no funcionaban los
// tooltips de Bootstrap, ni el toggle del sidebar en móvil.
//
// Solución: se elimina el import de módulo y se configura axios (si está
// disponible vía CDN) de forma compatible con un script clásico.

if (window.axios) {
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}

document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    }

    // Auto-close alerts
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function (alert) {
            if (window.bootstrap && window.bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    }, 4000);

    // Confirm delete
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm('¿Está seguro de que desea eliminar este registro? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });

    // Preview image upload
    const fotoInput = document.getElementById('foto');
    if (fotoInput) {
        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    const preview = document.getElementById('foto-preview');
                    if (preview) preview.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Tooltips
    if (window.bootstrap && window.bootstrap.Tooltip) {
        const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipEls.forEach(el => new bootstrap.Tooltip(el));
    }
});
