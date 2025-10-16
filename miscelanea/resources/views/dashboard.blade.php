<x-app-layout>
    <div class="py-10" style="background-color: #111827; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Bienvenida -->
            <div class="bg-gray-800 text-gray-100 overflow-hidden shadow-lg sm:rounded-xl mb-8 border border-gray-700">
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bi bi-shop text-4xl me-4 text-emerald-400"></i>
                        <div>
                            <h3 class="text-2xl font-bold">¡Bienvenido, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-400 text-sm">Panel principal del sistema de gestión de inventario</p>
                        </div>
                    </div>
                   
                </div>
            </div>

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-emerald-600 text-white rounded-xl shadow-lg p-6 hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide">Total Productos</p>
                            <h3 class="text-4xl font-bold mt-1">{{ \App\Models\Producto::count() }}</h3>
                        </div>
                        <i class="bi bi-box-seam text-5xl opacity-75"></i>
                    </div>
                </div>

                <div class="bg-indigo-600 text-white rounded-xl shadow-lg p-6 hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide">Categorías</p>
                            <h3 class="text-4xl font-bold mt-1">{{ \App\Models\Categoria::count() }}</h3>
                        </div>
                        <i class="bi bi-tags text-5xl opacity-75"></i>
                    </div>
                </div>

                <div class="bg-amber-500 text-white rounded-xl shadow-lg p-6 hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide">Productos Activos</p>
                            <h3 class="text-4xl font-bold mt-1">{{ \App\Models\Producto::where('is_activo', true)->count() }}</h3>
                        </div>
                        <i class="bi bi-check-circle text-5xl opacity-75"></i>
                    </div>
                </div>
            </div>

            <!-- Gráfico -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 mb-8">
                <h4 class="text-lg font-bold mb-4 text-gray-100 flex items-center">
                    <i class="bi bi-pie-chart-fill text-emerald-400 mr-2"></i>
                    Distribución de Productos por Categoría
                </h4>
                <div class="bg-gray-900 p-4 rounded-lg">
                    <canvas id="chartCategorias" style="height: 280px;"></canvas>
                </div>
            </div>

            <!-- Tablas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Últimos productos -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                    <h4 class="text-lg font-bold mb-4 text-gray-100 flex items-center">
                        <i class="bi bi-clock-history text-emerald-400 mr-2"></i>
                        Últimos productos registrados
                    </h4>
                    @php
                        $ultimosProductos = \App\Models\Producto::take(5)->get();
                    @endphp
                    <table class="w-full text-sm text-gray-300 border-collapse">
                        <thead class="bg-gray-900 text-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Nombre</th>
                                <th class="px-4 py-2 text-left">Categoría</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimosProductos as $producto)
                            <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                <td class="px-4 py-2">{{ $producto->nombre }}</td>
                                <td class="px-4 py-2">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Productos con bajo stock -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                    <h4 class="text-lg font-bold mb-4 text-gray-100 flex items-center">
                        <i class="bi bi-exclamation-triangle-fill text-amber-400 mr-2"></i>
                        Productos con bajo stock
                    </h4>
                    @php
                        $bajoStock = \App\Models\Producto::where('cantidad', '<=', 5)->get();
                    @endphp
                    <table class="w-full text-sm text-gray-300 border-collapse">
                        <thead class="bg-gray-900 text-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Producto</th>
                                <th class="px-4 py-2 text-center">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bajoStock as $prod)
                            <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                <td class="px-4 py-2">{{ $prod->nombre }}</td>
                                <td class="px-4 py-2 text-center">
                                    <span class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
                                        {{ $prod->cantidad }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-gray-400">No hay productos con bajo stock</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartCategorias').getContext('2d');
        const categorias = @json(\App\Models\Categoria::pluck('nombre'));
        const conteo = @json(\App\Models\Categoria::withCount('productos')->pluck('productos_count'));

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: categorias,
                datasets: [{
                    label: 'Productos',
                    data: conteo,
                    backgroundColor: [
                        '#10b981', '#6366f1', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'
                    ],
                    borderColor: '#111827',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#e5e7eb' }
                    }
                }
            }
        });
    </script>
</x-app-layout>
