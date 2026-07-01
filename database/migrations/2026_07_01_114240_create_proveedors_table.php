<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Nombre del proveedor
            $table->string('contacto')->nullable(); // Persona de contacto
            $table->string('telefono')->nullable(); // Teléfono del proveedor
            $table->string('email')->nullable(); // Correo electrónico
            $table->string('direccion')->nullable(); // Dirección física
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
