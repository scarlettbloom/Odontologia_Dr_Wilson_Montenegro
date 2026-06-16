<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'idventa'; // ✅ coincide con la migración
    public $timestamps = true; // ✅ la tabla tiene timestamps

    protected $fillable = [
        'producto_id',
        'cantidad',
        'subtotal',
        'descuento',
        'total',
    ];

    public function producto()
    {
        return $this->belongsTo(Inventario::class, 'producto_id', 'idinventario');
    }
}
