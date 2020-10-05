<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cpf',  11)->unique();
            $table->string('nome');
            $table->string('cargo')->nullable();
            $table->string('setor')->nullable();
            $table->string('foto', 100)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('token')->nullable();
            $table->boolean('alterar_senha');
            $table->boolean('ativo');
            $table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
