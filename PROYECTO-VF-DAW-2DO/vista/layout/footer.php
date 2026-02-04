    <!-- Modal de Confirmación -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="bi bi-exclamation-circle"></i> Confirmar Acción</h2>
                <button type="button" class="modal-close" onclick="cerrarConfirmModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">¿Está seguro de que desea continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrarConfirmModal()"><i class="bi bi-x-circle"></i> Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarAccion()"><i class="bi bi-check-circle"></i> Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Modal de Mensajes (Éxito/Error/Info) -->
    <div id="messageModal" class="modal">
        <div class="modal-content" id="messageModalContent">
            <div class="modal-header" id="messageModalHeader">
                <h2 id="messageModalTitle"><i class="bi bi-check-circle"></i> Operación Exitosa</h2>
                <button type="button" class="modal-close" onclick="cerrarMessageModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p id="messageText">Operación completada correctamente</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="cerrarMessageModal()"><i class="bi bi-check-circle"></i> Aceptar</button>
            </div>
        </div>
    </div>

    <script>
        let urlConfirmacion = '';

        function abrirConfirmModal(url, mensaje = '¿Está seguro de que desea eliminar este elemento?') {
            urlConfirmacion = url;
            document.getElementById('confirmMessage').innerHTML = mensaje;
            document.getElementById('confirmModal').style.display = 'flex';
        }

        function cerrarConfirmModal() {
            document.getElementById('confirmModal').style.display = 'none';
            urlConfirmacion = '';
        }

        function confirmarAccion() {
            if (urlConfirmacion) {
                window.location.href = urlConfirmacion;
            }
        }

        function abrirMessageModal(titulo, mensaje, tipo = 'success') {
            const iconos = {
                success: 'check-circle',
                error: 'exclamation-triangle',
                warning: 'exclamation-circle',
                info: 'info-circle'
            };

            const colores = {
                success: 'var(--color-success)',
                error: 'var(--color-danger)',
                warning: 'var(--color-warning)',
                info: 'var(--color-primary)'
            };

            const header = document.getElementById('messageModalHeader');
            const icon = document.getElementById('messageModalTitle').querySelector('i');
            
            header.style.borderLeftColor = colores[tipo];
            header.style.borderLeftWidth = '4px';
            header.style.borderLeftStyle = 'solid';
            
            document.getElementById('messageModalTitle').innerHTML = `<i class="bi bi-${iconos[tipo]}"></i> ${titulo}`;
            document.getElementById('messageModalTitle').querySelector('i').style.color = colores[tipo];
            document.getElementById('messageText').innerHTML = mensaje;
            
            document.getElementById('messageModal').style.display = 'flex';
            
            // Cerrar automáticamente después de 3 segundos
            setTimeout(() => {
                cerrarMessageModal();
            }, 3000);
        }

        function cerrarMessageModal() {
            document.getElementById('messageModal').style.display = 'none';
        }

        // Cerrar modales al hacer clic fuera de ellos
        window.onclick = function(event) {
            const confirmModal = document.getElementById('confirmModal');
            const messageModal = document.getElementById('messageModal');
            
            if (event.target === confirmModal) {
                cerrarConfirmModal();
            }
            if (event.target === messageModal) {
                cerrarMessageModal();
            }
        }

        // Mostrar mensaje si viene en sesión
        document.addEventListener('DOMContentLoaded', function() {
            const mensaje = document.body.getAttribute('data-mensaje');
            const error = document.body.getAttribute('data-error');
            const info = document.body.getAttribute('data-info');

            if (mensaje) {
                abrirMessageModal('✓ Operación Exitosa', mensaje, 'success');
            } else if (error) {
                abrirMessageModal('✗ Error', error, 'error');
            } else if (info) {
                abrirMessageModal('ℹ Información', info, 'info');
            }
        });
    </script>

</body>
</html>
