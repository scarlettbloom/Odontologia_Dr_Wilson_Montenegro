<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas'; // nombre de la tabla
    protected $primaryKey = 'idventa'; // si tu PK no es 'id', cámbiala aquí

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
