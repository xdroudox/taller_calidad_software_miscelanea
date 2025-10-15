<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Categoria
 * 
 * @property int $pk_id_categoria
 * @property string $nombre
 * @property string $descripcion
 * 
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class Categoria extends Model
{
	protected $table = 'categorias';
	protected $primaryKey = 'pk_id_categoria';
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'descripcion'
	];

	public function productos()
	{
		return $this->hasMany(Producto::class, 'fk_id_categoria');
	}
}
