<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_cita', function (Blueprint $table) {
            $table->increments('iddetalle_cita');
            $table->string('tipo_cita', 50)->nullable();
            $table->text('descripcion_cita')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_cita');
    }
};