<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';

    protected $primaryKey = 'idservicio';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo'
    ];
}
