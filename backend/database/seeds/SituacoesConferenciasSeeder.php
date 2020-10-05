<?php

use Illuminate\Database\Seeder;

class SituacoesConferenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('conferencias_situacoes')->insert([
            ['id' => 1, 'ativo' => true, 'nome' => 'Pendente'],
            ['id' => 2, 'ativo' => true, 'nome' => 'Aprovado'],
            ['id' => 3, 'ativo' => true, 'nome' => 'Rejeitado'],
            ['id' => 4, 'ativo' => true, 'nome' => 'Aguardando Correção'],
            ['id' => 5, 'ativo' => true, 'nome' => 'Corrigido'],
            ['id' => 6, 'ativo' => true, 'nome' => 'Em Análise']
        ]);
    }
}
