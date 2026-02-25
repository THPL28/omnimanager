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
            if (!Schema::hasColumn('grupo_economicos', 'cnpj')) {
                $table->string('cnpj', 20)->nullable()->after('nome');
            }
            if (!Schema::hasColumn('grupo_economicos', 'responsavel')) {
                $table->string('responsavel')->nullable()->after('nome');
            }
            if (!Schema::hasColumn('grupo_economicos', 'status')) {
                $table->string('status')->default('ativo')->after('nome');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupo_economicos', function (Blueprint $table) {
            // No rollback for fix migration to prevent data loss or complexity
        });
    }
};
