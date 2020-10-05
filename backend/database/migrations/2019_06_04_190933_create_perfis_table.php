<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfisTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('perfis', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->longText('descricao')->nullable();
            $table->boolean('ativo');
            $table->boolean('publico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('perfis');
    }
}
