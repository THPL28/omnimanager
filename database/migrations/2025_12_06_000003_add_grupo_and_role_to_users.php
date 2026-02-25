<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('grupo_economico_id')->nullable()->after('id')->index();
            $table->string('role')->default('user')->after('email');

            $table->foreign('grupo_economico_id')->references('id')->on('grupo_economicos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['grupo_economico_id']);
            $table->dropColumn(['grupo_economico_id','role']);
        });
    }
};
