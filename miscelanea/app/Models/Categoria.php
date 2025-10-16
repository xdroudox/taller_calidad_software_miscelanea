<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'pk_id_categoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // AGREGA ESTO para el Route Model Binding
    public function getRouteKeyName()
    {
        return 'pk_id_categoria';
    }

    public function productos()
{
    return $this->hasMany(Producto::class, 'fk_id_categoria', 'pk_id_categoria');
}

}