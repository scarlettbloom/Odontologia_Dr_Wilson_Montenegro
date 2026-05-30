<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Usuario
 * Tabla: Usuario
 * Equivale a model/Usuario.php del proyecto original.
 */
class Usuario extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'ID';
    public    $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Apellido',
        'Email',
        'Telefono',
        'password',
        'Rol',
    ];

    // Ocultar la clave en serialización
    protected $hidden = ['password'];

    // ── Relaciones ────────────────────────────────────────────────────────
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'ID', 'ID');
    }
}
