<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Cliente
 * Tabla: cliente
 */
class Cliente extends Model
{
    protected $table      = 'cliente';
    protected $primaryKey = 'idcliente';
    public    $timestamps = false;

    protected $fillable = ['id', 'idservicio'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'idcliente', 'idcliente');
    }
}
