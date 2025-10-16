<x-app-layout>
@vite(['resources/css/categorias.css'])
    <div class="categorias-container">
        <div class="categorias-card">
            <!-- Mensajes -->
            @if(session('success'))
                <div class="cat-alert success">
                    <span><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</span>
                    <button class="cat-alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="cat-alert danger">
                    <span><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</span>
                    <button class="cat-alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <!-- Botón Nueva Categoría -->
            <div style="margin-bottom: 2rem;">
                <button type="button" class="cat-btn primary" onclick="openCatModal('createModal')">
                    <i class="bi bi-plus-circle-fill"></i>
                    Nueva Categoría
                </button>
            </div>

            <!-- Tabla -->
            <div class="cat-table-wrapper">
                <table class="cat-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>N° Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->pk_id_categoria }}</td>
                            <td><strong>{{ $categoria->nombre }}</strong></td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>
                                <span class="cat-badge info">{{ $categoria->productos_count }}</span>
                            </td>
                            <td>
                                <div class="btn-actions">
                                    <button type="button" class="cat-btn warning sm" onclick='editCategoria(@json($categoria))'>
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline-form" onsubmit="return confirm('¿Está seguro de eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cat-btn danger sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Crear -->
    <div class="cat-modal" id="createModal">
        <div class="cat-modal-dialog">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="cat-modal-header">
                    <h5 class="cat-modal-title">Nueva Categoría</h5>
                    <button type="button" class="cat-modal-close" onclick="closeCatModal('createModal')">&times;</button>
                </div>
                <div class="cat-modal-body">
                    <div class="cat-form-group">
                        <label class="cat-label">Nombre *</label>
                        <input type="text" name="nombre" class="cat-input" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="cat-form-group">
                        <label class="cat-label">Descripción *</label>
                        <textarea name="descripcion" class="cat-textarea" required>{{ old('descripcion') }}</textarea>
                    </div>
                </div>
                <div class="cat-modal-footer">
                    <button type="button" class="cat-btn secondary" onclick="closeCatModal('createModal')">Cancelar</button>
                    <button type="submit" class="cat-btn primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="cat-modal" id="editModal">
        <div class="cat-modal-dialog">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="cat-modal-header">
                    <h5 class="cat-modal-title">Editar Categoría</h5>
                    <button type="button" class="cat-modal-close" onclick="closeCatModal('editModal')">&times;</button>
                </div>
                <div class="cat-modal-body">
                    <div class="cat-form-group">
                        <label class="cat-label">Nombre *</label>
                        <input type="text" name="nombre" id="edit_nombre" class="cat-input" required>
                    </div>
                    <div class="cat-form-group">
                        <label class="cat-label">Descripción *</label>
                        <textarea name="descripcion" id="edit_descripcion" class="cat-textarea" required></textarea>
                    </div>
                </div>
                <div class="cat-modal-footer">
                    <button type="button" class="cat-btn secondary" onclick="closeCatModal('editModal')">Cancelar</button>
                    <button type="submit" class="cat-btn warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script>
        function openCatModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }

        function closeCatModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        function editCategoria(categoria) {
            document.getElementById('editForm').action = `/categorias/${categoria.pk_id_categoria}`;
            document.getElementById('edit_nombre').value = categoria.nombre;
            document.getElementById('edit_descripcion').value = categoria.descripcion;
            openCatModal('editModal');
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            if (event.target.classList.contains('cat-modal')) {
                event.target.classList.remove('show');
            }
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.cat-modal.show').forEach(modal => {
                    modal.classList.remove('show');
                });
            }
        });
    </script>
</x-app-layout>