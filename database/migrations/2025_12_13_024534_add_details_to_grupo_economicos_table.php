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
        Schema::table('grupo_economicos', function (Blueprint $table) {
            $table->string('cnpj', 20)->nullable()->after('nome');
            $table->string('responsavel')->nullable()->after('cnpj');
            $table->string('status')->default('ativo')->after('responsavel'); // ativo, pendente, arquivado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupo_economicos', function (Blueprint $table) {
            $table->dropColumn(['cnpj', 'responsavel', 'status']);
        });
    }
};
