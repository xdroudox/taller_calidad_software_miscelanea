<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'pk_id_producto';
    public $timestamps = false;

    protected $casts = [
        'cantidad' => 'int',
        'precio_unitario' => 'float',
        'fecha_registro' => 'datetime',
        'is_activo' => 'bool',
        'fk_id_categoria' => 'int'
    ];

    protected $fillable = [
        'cod_barras',
        'nombre',
        'cantidad',
        'marca',
        'precio_unitario',
        'fecha_registro',
        'is_activo',
        'fk_id_categoria'
    ];

    // AGREGA ESTO para el Route Model Binding
    public function getRouteKeyName()
    {
        return 'pk_id_producto';
    }

    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'fk_id_categoria', 'pk_id_categoria');
}

}