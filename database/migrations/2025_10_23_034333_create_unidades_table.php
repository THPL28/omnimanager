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
       Schema::create('unidades', function (Blueprint $table) {
            $table->id(); // ID 
            $table->string('nome_fantasia');
            $table->string('razao_social'); 
            $table->string('cnpj', 18)->unique(); // CNPJ (14 dígitos + formato) deve ser único

           // Chave Estrangeira (FK) para Bandeira
            $table->foreignId('bandeira_id')
                  ->constrained('bandeiras')
                  ->onDelete('restrict'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades');
    }
};
