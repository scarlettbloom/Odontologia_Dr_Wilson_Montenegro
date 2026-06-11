<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimiento_stocks', function (Blueprint $table) {
    $table->id();
    $table->unsignedInteger('producto_id');
    $table->string('tipo');
    $table->integer('cantidad');
    $table->string('descripcion')->nullable();
    $table->string('responsable')->nullable();
    $table->timestamps();

    $table->foreign('producto_id')
        ->references('idinventario')
        ->on('inventario')
        ->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('movimiento_stocks');
    }
};
