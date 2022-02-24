<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwDocumentosCorporativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_documentos_corporativos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tw_corporativos_id');
            $table->unsignedBigInteger('tw_documentos_id');
            $table->string('S_ArchivoUrl', 255)->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tw_documentos_corporativos');
    }
}
