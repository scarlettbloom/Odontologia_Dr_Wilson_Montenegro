<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->increments('iddetalle_venta');
            $table->unsignedInteger('idventa')->nullable();
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->foreign('idventa')
                  ->references('idventa')
                  ->on('ventas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_venta');
    }
};