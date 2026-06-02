
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id('idinventario');
            $table->string('nombre', 50);
            $table->integer('stock');
            $table->decimal('precio_unitario', 10, 2);
            $table->string('nombre_proveedor', 50);
            $table->unsignedBigInteger('idproducto')->nullable();
            $table->foreign('idproducto')->references('idproducto')->on('producto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};