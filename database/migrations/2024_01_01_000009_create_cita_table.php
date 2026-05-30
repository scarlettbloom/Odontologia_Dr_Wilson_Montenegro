<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cita', function (Blueprint $table) {
            $table->increments('idcita');
            $table->dateTime('fecha_entrada')->nullable();
            $table->dateTime('fecha_salida')->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
            $table->string('tipo', 50)->nullable();
            $table->unsignedInteger('iddetalle_cita')->nullable();
            $table->unsignedInteger('idcliente')->nullable();
            $table->unsignedInteger('idservicio')->nullable();
            $table->foreign('iddetalle_cita')
                  ->references('iddetalle_cita')
                  ->on('detalle_cita')
                  ->onDelete('set null');
            $table->foreign('idservicio')
                  ->references('idservicio')
                  ->on('servicio')
                  ->onDelete('set null');
            $table->foreign('idcliente')
                  ->references('idcliente')
                  ->on('cliente')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cita');
    }
};