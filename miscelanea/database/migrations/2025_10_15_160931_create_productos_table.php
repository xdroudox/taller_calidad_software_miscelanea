<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('pk_id_producto');
            $table->string('cod_barras', 50)->unique('cod_barras');
            $table->string('nombre', 50);
            $table->integer('cantidad')->nullable()->default(0);
            $table->string('marca', 35);
            $table->double('precio_unitario')->nullable()->default(0);
            $table->timestamp('fecha_registro')->useCurrentOnUpdate()->useCurrent();
            $table->boolean('is_activo')->nullable();
            $table->unsignedBigInteger('fk_id_categoria')->index('fk_id_categoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
