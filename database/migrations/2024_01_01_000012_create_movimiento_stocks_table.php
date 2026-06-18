<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       // database/migrations/2026_06_11_000000_create_movimientos_stock_table.php
Schema::create('movimientos_stock', function (Blueprint $table) {
    $table->id();
    $table->date('fecha');
    $table->string('producto');
    $table->enum('tipo', ['Entrada', 'Salida']);
    $table->integer('cantidad');
    $table->string('responsable');
    $table->timestamps();
    $table->integer('producto_id')->unsigned()->nullable();
});

    }};
