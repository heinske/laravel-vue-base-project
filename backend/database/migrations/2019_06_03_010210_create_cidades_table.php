<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidades', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('cidade');
            $table->integer('estado_id')->unsigned()->default(0);
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->integer('qtde_delegados')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cidades');
    }
}
