<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->increments('idventa');
            $table->date('fecha')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->unsignedInteger('idservicio')->nullable();
            $table->unsignedInteger('idinventario')->nullable();
            $table->foreign('idinventario')
                  ->references('idinventario')
                  ->on('inventario')
                  ->onDelete('set null');
            $table->foreign('idservicio')
                  ->references('idservicio')
                  ->on('servicio')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};