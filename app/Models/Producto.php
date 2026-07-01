<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';

    protected $primaryKey = 'idproducto';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'marca',
        'precio',
        'idproveedor',
        'idadmin',
        'descripcion',
    ];

    public function proveedor()
{
    return $this->belongsTo(Proveedor::class);
}

}

