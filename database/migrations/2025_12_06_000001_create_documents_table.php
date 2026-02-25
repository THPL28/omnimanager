<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grupo_economico_id')->nullable()->index();
            $table->string('setor')->nullable();
            $table->string('descricao')->nullable();
            $table->string('current_path')->nullable();
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('grupo_economico_id')->references('id')->on('grupo_economicos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
