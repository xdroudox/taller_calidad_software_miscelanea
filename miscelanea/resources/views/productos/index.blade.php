<x-app-layout>
   @vite('resources/css/productos.css')

    <div class="productos-container">
        <div class="productos-card">
            <!-- Mensajes -->
            @if(session('success'))
                <div class="custom-alert success">
                    <span><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</span>
                    <button class="custom-alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="custom-alert danger">
                    <span><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</span>
                    <button class="custom-alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <!-- Botón Nuevo -->
            <div style="margin-bottom: 2rem;">
                <button type="button" class="custom-btn primary" onclick="openCustomModal('createModal')">
                    <i class="bi bi-plus-circle-fill"></i>
                    Nuevo Producto
                </button>
            </div>

            <!-- Tabla -->
            <div class="custom-table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Categoría</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->pk_id_producto }}</td>
                            <td><span class="custom-code">{{ $producto->cod_barras }}</span></td>
                            <td><strong>{{ $producto->nombre }}</strong></td>
                            <td>{{ $producto->marca }}</td>
                            <td>
                                <span class="custom-badge secondary">{{ $producto->categoria->nombre }}</span>
                            </td>
                            <td>
                                <span class="custom-badge {{ $producto->cantidad > 10 ? 'success' : ($producto->cantidad > 0 ? 'warning' : 'danger') }}">
                                    {{ $producto->cantidad ?? 0 }}
                                </span>
                            </td>
                            <td><strong>${{ number_format($producto->precio_unitario ?? 0, 2) }}</strong></td>
                            <td>
                                @if($producto->is_activo)
                                    <span class="custom-badge success">
                                        <i class="bi bi-check-circle-fill"></i> Activo
                                    </span>
                                @else
                                    <span class="custom-badge danger">
                                        <i class="bi bi-x-circle-fill"></i> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-actions">
                                    <button type="button" class="custom-btn warning sm" onclick='editProducto(@json($producto))'>
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline-form" onsubmit="return confirm('¿Está seguro de eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="custom-btn danger sm">
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
    <div class="custom-modal" id="createModal">
        <div class="custom-modal-dialog">
            <form action="{{ route('productos.store') }}" method="POST">
                @csrf
                <div class="custom-modal-header">
                    <h5 class="custom-modal-title">Nuevo Producto</h5>
                    <button type="button" class="custom-modal-close" onclick="closeCustomModal('createModal')">&times;</button>
                </div>
                <div class="custom-modal-body">
                    <div class="custom-row">
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Código de Barras *</label>
                                <input type="text" name="cod_barras" class="custom-input" value="{{ old('cod_barras') }}" required>
                            </div>
                        </div>
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Nombre *</label>
                                <input type="text" name="nombre" class="custom-input" value="{{ old('nombre') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Marca *</label>
                                <input type="text" name="marca" class="custom-input" value="{{ old('marca') }}" required>
                            </div>
                        </div>
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Categoría *</label>
                                <select name="fk_id_categoria" class="custom-input" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->pk_id_categoria }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Cantidad</label>
                                <input type="number" name="cantidad" class="custom-input" value="{{ old('cantidad', 0) }}" min="0">
                            </div>
                        </div>
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Precio Unitario</label>
                                <input type="number" name="precio_unitario" class="custom-input" value="{{ old('precio_unitario', 0) }}" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="custom-checkbox-wrapper">
                        <input type="checkbox" name="is_activo" id="is_activo" class="custom-checkbox" value="1" checked>
                        <label class="custom-label" for="is_activo" style="margin: 0;">Producto Activo</label>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="custom-btn secondary" onclick="closeCustomModal('createModal')">Cancelar</button>
                    <button type="submit" class="custom-btn primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="custom-modal" id="editModal">
        <div class="custom-modal-dialog">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="custom-modal-header">
                    <h5 class="custom-modal-title">Editar Producto</h5>
                    <button type="button" class="custom-modal-close" onclick="closeCustomModal('editModal')">&times;</button>
                </div>
                <div class="custom-modal-body">
                    <div class="custom-row">
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Código de Barras *</label>
                                <input type="text" name="cod_barras" id="edit_cod_barras" class="custom-input" required>
                            </div>
                        </div>
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Nombre *</label>
                                <input type="text" name="nombre" id="edit_nombre" class="custom-input" required>
                            </div>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Marca *</label>
                                <input type="text" name="marca" id="edit_marca" class="custom-input" required>
                            </div>
                        </div>
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Categoría *</label>
                                <select name="fk_id_categoria" id="edit_fk_id_categoria" class="custom-input" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->pk_id_categoria }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Cantidad</label>
                                <input type="number" name="cantidad" id="edit_cantidad" class="custom-input" min="0">
                            </div>
                        </div>
                        <div class="custom-col">
                            <div class="custom-form-group">
                                <label class="custom-label">Precio Unitario</label>
                                <input type="number" name="precio_unitario" id="edit_precio_unitario" class="custom-input" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="custom-checkbox-wrapper">
                        <input type="checkbox" name="is_activo" id="edit_is_activo" class="custom-checkbox" value="1">
                        <label class="custom-label" for="edit_is_activo" style="margin: 0;">Producto Activo</label>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="custom-btn secondary" onclick="closeCustomModal('editModal')">Cancelar</button>
                    <button type="submit" class="custom-btn warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script>
        function openCustomModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }

        function closeCustomModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        function editProducto(producto) {
            document.getElementById('editForm').action = `/productos/${producto.pk_id_producto}`;
            document.getElementById('edit_cod_barras').value = producto.cod_barras;
            document.getElementById('edit_nombre').value = producto.nombre;
            document.getElementById('edit_marca').value = producto.marca;
            document.getElementById('edit_fk_id_categoria').value = producto.fk_id_categoria;
            document.getElementById('edit_cantidad').value = producto.cantidad ?? 0;
            document.getElementById('edit_precio_unitario').value = producto.precio_unitario ?? 0;
            document.getElementById('edit_is_activo').checked = producto.is_activo;
            openCustomModal('editModal');
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            if (event.target.classList.contains('custom-modal')) {
                event.target.classList.remove('show');
            }
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.custom-modal.show').forEach(modal => {
                    modal.classList.remove('show');
                });
            }
        });
    </script>
</x-app-layout>