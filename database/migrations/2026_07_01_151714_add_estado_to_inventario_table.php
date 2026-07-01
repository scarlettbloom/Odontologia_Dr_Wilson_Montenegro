<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('inventario', function (Blueprint $table) {
        $table->enum('estado', ['activo', 'inactivo'])->default('activo');
    });
}

public function down()
{
    Schema::table('inventario', function (Blueprint $table) {
        $table->dropColumn('estado');
    });
}

};
