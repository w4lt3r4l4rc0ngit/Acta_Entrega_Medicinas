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
        Schema::create('acta_entrega_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_acta_entrega');
            $table->unsignedBigInteger('id_medicina');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('estado')->default('1');
            $table->timestamps();
            // Claves foráneas
            $table->foreign('id_acta_entrega')
                ->references('id')
                ->on('acta_entregas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_medicina')
                ->references('id')
                ->on('medicinas')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acta_entrega_detalles');
    }
};
