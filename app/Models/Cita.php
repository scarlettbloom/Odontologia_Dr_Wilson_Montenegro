<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Cita
 * Tabla: Cita
 */
class Cita extends Model
{
    protected $table      = 'Cita';
    protected $primaryKey = 'IDcita';
    public    $timestamps = false;

    protected $fillable = [
        'Fecha_entrada',
        'Fecha_salida',
        'Estado',
        'Tipo',
        'IDcliente',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'IDcliente', 'IDcliente');
    }
}
