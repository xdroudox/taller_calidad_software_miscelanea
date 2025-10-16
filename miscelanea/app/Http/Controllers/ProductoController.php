<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar la lista de productos.
     */
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();

        return view('productos.index', compact('productos', 'categorias'));
    }

    /**
     * Almacenar un nuevo producto.
     */
    public function store(Request $request)
{
    $request->validate([
        'cod_barras' => 'required|string|max:50|unique:productos,cod_barras',
        'nombre' => 'required|string|max:50|unique:productos,nombre',
        'marca' => 'required|string|max:35',
        'cantidad' => 'nullable|integer|min:0',
        'precio_unitario' => 'required|numeric|min:0',
        'fk_id_categoria' => 'required|exists:categorias,pk_id_categoria',
    ]);

    $data = $request->all();
    $data['fecha_registro'] = now();
    $data['is_activo'] = $request->has('is_activo');

    Producto::create($data);

    return redirect()->route('productos.index')
        ->with('success', 'Producto creado exitosamente');
}

    /**
     * Actualizar un producto existente.
     */
    public function update(Request $request, Producto $producto)
{
    $request->validate([
        'cod_barras' => 'required|string|max:50|unique:productos,cod_barras,' . $producto->pk_id_producto . ',pk_id_producto',
        'nombre' => 'required|string|max:50|unique:productos,nombre,' . $producto->pk_id_producto . ',pk_id_producto',
        'marca' => 'required|string|max:35',
        'cantidad' => 'nullable|integer|min:0',
        'precio_unitario' => 'required|numeric|min:0',
        'fk_id_categoria' => 'required|exists:categorias,pk_id_categoria',
    ]);

    $data = $request->all();
    $data['is_activo'] = $request->has('is_activo');

    $producto->update($data);

    return redirect()->route('productos.index')
        ->with('success', 'Producto actualizado exitosamente');
}


    /**
     * Eliminar un producto.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
