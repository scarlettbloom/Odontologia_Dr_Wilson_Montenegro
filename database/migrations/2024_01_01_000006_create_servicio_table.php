<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicio', function (Blueprint $table) {
            $table->increments('idservicio');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('costo', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};