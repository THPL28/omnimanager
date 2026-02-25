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
     Schema::create('bandeiras', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique(); // Requisito de validação (unicidade)
            
            // Chave Estrangeira (FK) para Grupo Econômico
            // Restringe a exclusão de um Grupo se ele tiver Bandeiras associadas
            $table->foreignId('grupo_economico_id')
                  ->constrained('grupo_economicos')
                  ->onDelete('restrict'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bandeiras');
    }
};
