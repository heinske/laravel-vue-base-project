<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEstados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('estados')->insert([
            ['estado' => 'Acre',                'sigla' => 'AC', 'regiao' => 'Norte',        'qtde_delegados' => 16], 
            ['estado' => 'Alagoas',             'sigla' => 'AL', 'regiao' => 'Nordeste',     'qtde_delegados' => 18],
            ['estado' => 'Amapá',               'sigla' => 'AP', 'regiao' => 'Norte',        'qtde_delegados' => 16],
            ['estado' => 'Amazonas',            'sigla' => 'AM', 'regiao' => 'Norte',        'qtde_delegados' => 16],
            ['estado' => 'Bahia',               'sigla' => 'BA', 'regiao' => 'Nordeste',     'qtde_delegados' => 78],
            ['estado' => 'Ceará',               'sigla' => 'CE', 'regiao' => 'Nordeste',     'qtde_delegados' => 44],
            ['estado' => 'Distrito Federal',    'sigla' => 'DF', 'regiao' => 'Centro Oeste', 'qtde_delegados' => 16],
            ['estado' => 'Espírito Santo',      'sigla' => 'ES', 'regiao' => 'Sudeste',      'qtde_delegados' => 20],
            ['estado' => 'Goiás',               'sigla' => 'GO', 'regiao' => 'Centro Oeste', 'qtde_delegados' => 34],
            ['estado' => 'Maranhão',            'sigla' => 'MA', 'regiao' => 'Nordeste',     'qtde_delegados' => 36],
            ['estado' => 'Mato Grosso',         'sigla' => 'MT', 'regiao' => 'Centro Oeste', 'qtde_delegados' => 16],
            ['estado' => 'Mato Grosso do Sul',  'sigla' => 'MS', 'regiao' => 'Centro Oeste', 'qtde_delegados' => 16],
            ['estado' => 'Minas Gerais',        'sigla' => 'MG', 'regiao' => 'Sudeste',      'qtde_delegados' => 106],
            ['estado' => 'Pará',                'sigla' => 'PA', 'regiao' => 'Norte',        'qtde_delegados' => 34],
            ['estado' => 'Paraíba',             'sigla' => 'PB', 'regiao' => 'Nordeste',     'qtde_delegados' => 24],
            ['estado' => 'Paraná',              'sigla' => 'PR', 'regiao' => 'Sul',          'qtde_delegados' => 60],
            ['estado' => 'Pernambuco',          'sigla' => 'PE', 'regiao' => 'Nordeste',     'qtde_delegados' => 50],
            ['estado' => 'Piauí',               'sigla' => 'PI', 'regiao' => 'Nordeste',     'qtde_delegados' => 20],
            ['estado' => 'Rio de Janeiro',      'sigla' => 'RJ', 'regiao' => 'Sudeste',      'qtde_delegados' => 92],
            ['estado' => 'Rio Grande do Norte', 'sigla' => 'RN', 'regiao' => 'Nordeste',     'qtde_delegados' => 16],
            ['estado' => 'Rio Grande do Sul',   'sigla' => 'RS', 'regiao' => 'Sul',          'qtde_delegados' => 62],
            ['estado' => 'Rondônia',            'sigla' => 'RO', 'regiao' => 'Norte',        'qtde_delegados' => 16],
            ['estado' => 'Roraima',             'sigla' => 'RR', 'regiao' => 'Norte',        'qtde_delegados' => 16],
            ['estado' => 'Santa Catarina',      'sigla' => 'SC', 'regiao' => 'Sul',          'qtde_delegados' => 32],
            ['estado' => 'São Paulo',           'sigla' => 'SP', 'regiao' => 'Sudeste',      'qtde_delegados' => 140],
            ['estado' => 'Sergipe',             'sigla' => 'SE', 'regiao' => 'Nordeste',     'qtde_delegados' => 16],
            ['estado' => 'Tocantins',           'sigla' => 'TO', 'regiao' => 'Norte',        'qtde_delegados' => 16]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
