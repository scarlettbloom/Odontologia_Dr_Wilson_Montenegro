<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoStock extends Model
{
    protected $table = 'movimiento_stocks'; // tu tabla real

    protected $fillable = [
        'producto_id',
        'tipo',
        'cantidad',
        'descripcion',
        'responsable'
    ];
}
