<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->increments('idinventario');
            $table->string('nombre', 50)->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->string('nombre_proveedor', 50)->nullable();
            $table->unsignedInteger('idproducto')->nullable();
            $table->foreign('idproducto')
                  ->references('idproducto')
                  ->on('producto')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};