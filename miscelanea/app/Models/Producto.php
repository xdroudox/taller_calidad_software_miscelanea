<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $pk_id_producto
 * @property string $cod_barras
 * @property string $nombre
 * @property int|null $cantidad
 * @property string $marca
 * @property float|null $precio_unitario
 * @property Carbon $fecha_registro
 * @property bool|null $is_activo
 * @property int $fk_id_categoria
 * 
 * @property Categoria $categoria
 *
 * @package App\Models
 */
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

	public function categoria()
	{
		return $this->belongsTo(Categoria::class, 'fk_id_categoria');
	}
}
