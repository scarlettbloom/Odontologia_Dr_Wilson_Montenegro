<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table      = 'inventario';
    protected $primaryKey = 'idinventario';
      public $timestamps    = false; 

    protected $fillable = [
        'nombre',
        'stock',
        'precio_unitario',
        'nombre_proveedor',
        'idproducto',
        'descripcion',
        'ultima_actualizacion',
    ];

    public function movimientos()
{
    return $this->hasMany(MovimientoStock::class, 'producto_id', 'idinventario');
}

}
