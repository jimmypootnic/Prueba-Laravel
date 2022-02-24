<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tw_usuarios', function (Blueprint $table) {
            $table->string('S_Nombre', 45)->nullable();
            $table->string('S_Apellidos', 45)->nullable();
            $table->string('S_FotoPerfilUrl', 255)->nullable();
            $table->boolean('Activo')->default(true);
            $table->string('verification_token', 191)->nullable();
            $table->string('verified', 191);
            $table->timestamp('delete_at')->nullable();
            $table->unsignedBigInteger('tw_rol_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tw_usuarios', function (Blueprint $table) {
            $table->dropColumn('S_Nombre', 45)->nullable();
            $table->dropColumn('S_Apellidos', 45)->nullable();
            $table->dropColumn('S_FotoPerfilUrl', 255)->nullable();
            $table->dropColumn('Activo')->default(true);
            $table->dropColumn('verification_token', 191)->nullable();
            $table->dropColumn('verified', 191);
            $table->dropColumn('delete_at')->nullable();
            $table->dropColumn('tw_rol_id');
        });
    }
}
