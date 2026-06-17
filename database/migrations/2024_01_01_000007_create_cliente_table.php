<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('idcliente');
            $table->unsignedInteger('idservicio')->nullable();
            $table->foreignId('id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreign('idservicio')
                  ->references('idservicio')
                  ->on('servicio')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};