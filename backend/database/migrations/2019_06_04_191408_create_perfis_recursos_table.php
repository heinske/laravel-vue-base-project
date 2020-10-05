<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfisRecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfis_recursos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('perfil_id');
            $table->integer('recurso_id');
            
            $table->foreign('perfil_id')->references('id')->on('perfis');
            $table->foreign('recurso_id')->references('id')->on('recursos');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfis_recursos');
    }
}
