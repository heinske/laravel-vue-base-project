<?php

use Illuminate\Database\Migrations\Migration;

class InsertPerfilRecursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('recursos')->insert([
            # Usuários
            ['id' => 1,  'recurso' => 'user', 'acao' => 'index', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Pesquisar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 2,  'recurso' => 'user', 'acao' => 'store', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Cadastrar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 3,  'recurso' => 'user', 'acao' => 'update', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Alterar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 4,  'recurso' => 'user', 'acao' => 'show', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Visualizar Detalhes', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 5,  'recurso' => 'user', 'acao' => 'destroy', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Remover do sistema', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            ['id' => 6,  'recurso' => 'user', 'acao' => 'aprovar', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Aprovar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 7,  'recurso' => 'user', 'acao' => 'rejeitar', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Rejeitar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 8,  'recurso' => 'user', 'acao' => 'excluir', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Excluir', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 9,  'recurso' => 'user', 'acao' => 'suspender', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Suspender', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            ['id' => 10,  'recurso' => 'user', 'acao' => 'ativar', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Ativar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],


            ['id' => 11,  'recurso' => 'user', 'acao' => 'solicitarAjuste', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Solicitar Ajuste', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 12,  'recurso' => 'user', 'acao' => 'enviarPendencia', 'nome_recurso' => 'Usuário', 'nome_acao' => 'Enviar Pendência', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            # Perfis
            ['id' => 13,  'recurso' => 'perfil', 'acao' => 'index', 'nome_recurso' => 'Perfil', 'nome_acao' => 'Pesquisar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 14,  'recurso' => 'perfil', 'acao' => 'store', 'nome_recurso' => 'Perfil', 'nome_acao' => 'Cadastrar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 15,  'recurso' => 'perfil', 'acao' => 'update', 'nome_recurso' => 'Perfil', 'nome_acao' => 'Alterar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 16,  'recurso' => 'perfil', 'acao' => 'show', 'nome_recurso' => 'Perfil', 'nome_acao' => 'Visualizar Detalhes', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 17,  'recurso' => 'perfil', 'acao' => 'destroy', 'nome_recurso' => 'Perfil', 'nome_acao' => 'Excluir', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],


        ]);

        \DB::table('perfis_recursos')->insert([
            // Administrador
            ['perfil_id' => 1, 'recurso_id' => 1],
            ['perfil_id' => 1, 'recurso_id' => 2],
            ['perfil_id' => 1, 'recurso_id' => 3],
            ['perfil_id' => 1, 'recurso_id' => 4],
            ['perfil_id' => 1, 'recurso_id' => 5],
            ['perfil_id' => 1, 'recurso_id' => 6],
            ['perfil_id' => 1, 'recurso_id' => 7],
            ['perfil_id' => 1, 'recurso_id' => 8],
            ['perfil_id' => 1, 'recurso_id' => 9],
            ['perfil_id' => 1, 'recurso_id' => 10],
            ['perfil_id' => 1, 'recurso_id' => 11],
            ['perfil_id' => 1, 'recurso_id' => 12],
            ['perfil_id' => 1, 'recurso_id' => 13],
            ['perfil_id' => 1, 'recurso_id' => 14],
            ['perfil_id' => 1, 'recurso_id' => 15],
            ['perfil_id' => 1, 'recurso_id' => 16],
            ['perfil_id' => 1, 'recurso_id' => 17]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfis_recursos');
        Schema::dropIfExists('recursos');
    }
}
