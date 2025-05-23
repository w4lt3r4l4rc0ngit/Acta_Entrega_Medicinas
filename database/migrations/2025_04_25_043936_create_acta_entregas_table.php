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
        Schema::create('acta_entregas', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20);
            $table->string('id_paciente', 13);
            $table->decimal('total', 8, 2);
            $table->string('estado')->default('1');
            $table->timestamps();
            $table->foreign('id_paciente')
                ->references('id')
                ->on('pacientes')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acta_entregas');
    }
};
