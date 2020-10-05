<?php

use Illuminate\Database\Seeder;

class TipoEixoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tipo_eixo')->insert([
            ['id' => 1, 'ativo' => true, 'nome' => 'Participação'],
            ['id' => 2, 'ativo' => true, 'nome' => 'Educação'],
            ['id' => 3, 'ativo' => true, 'nome' => 'Trabalho'],
            ['id' => 4, 'ativo' => true, 'nome' => 'Diversidade e Igualdade'],
            ['id' => 5, 'ativo' => true, 'nome' => 'Saúde'],
            ['id' => 6, 'ativo' => true, 'nome' => 'Cultura'],
            ['id' => 7, 'ativo' => true, 'nome' => 'Direito à Comunicação'],
            ['id' => 8, 'ativo' => true, 'nome' => 'Esporte e Lazer'],
            ['id' => 9, 'ativo' => true, 'nome' => 'Meio Ambiente'],
            ['id' => 10, 'ativo' => true, 'nome' => 'Território e Mobilidade'],
            ['id' => 11, 'ativo' => true, 'nome' => 'Segurança e Paz']
        ]);
    }
}
