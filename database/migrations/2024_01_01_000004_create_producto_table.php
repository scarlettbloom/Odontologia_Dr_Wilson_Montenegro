<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('idproducto');
            $table->string('nombre', 50)->nullable();
            $table->string('marca', 50)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};