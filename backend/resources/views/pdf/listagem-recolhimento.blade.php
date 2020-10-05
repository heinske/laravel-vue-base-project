<style>
    .text-header { 
        font-size: 12px;
    }

    .text-body { 
        font-size: 12px;
    }

    .text-center {
        text-align: center;
    }
    
    #pageCounter {
        counter-reset: pageTotal;
    }

    .pagenum:before {
        content: counter(page) "/" counter(pageTotal);  ;
    }



</style>
<table border="1" cellspacing="0" style="width: 100%">
    <thead class="text-header text-center">
        <tr>
            <td colspan="4">
                <strong>LISTAGEM DESCRITIVA DOS DOCUMENTOS NÃO DIGITAIS </strong><br />
            </td>
        </tr>
    </thead>
    <tbody class='text-body'>
        <tr>
            <td colspan="1">Forma de entrada:</td>
            <td colspan="3">( ) Transferência ( ) Recolhimento</td>
        </tr>
        <tr>
            <td colspan="1">Produtor(es) / Acumulador(es):</td>
            <td colspan="3">{{ $listagem['produtores_acumuladores'] }}</td>
        </tr>
        <tr>
            <td colspan="1">Procedência:</td>
            <td colspan="3">{{ $listagem['procedencia'] }}</td>
        </tr>
        <tr>
            <td colspan="1">Gênero documental:</td>
            <td colspan="3">{{ $listagem['genero_documental'] ? App\Models\ListagemRecolhimento::generos()[$listagem['genero_documental']] : 'Não Informado' }}</td>
        </tr>
        <tr>
            <td colspan="1">Dimensão (mensuração / quantificação):</td>
            <td colspan="3">{{ $listagem['mensuracao_total'] ? $listagem['mensuracao_total'] . ' Metros Lineares' : '' }}</td>
        </tr>
        <tr>
            <td>Tipo e nº das unidades de arquivamento</td>
            <td>Classificação e descrição do conteúdo das unidades de arquivamento</td>
            <td>Datas-limite</td>
            <td>Observações</td>
        </tr>
        @foreach($listagem['documentos'] as $documento)
        <tr>
            <td>{{ $documento['numero_documento'] }} - {{ $documento['tipo_documento']['titulo'] }}</td>
            <td>{{ $documento['classificacao']['codigo'] }} - {{ $documento['classificacao']['descricao'] }}  / {{ $documento['assunto'] }}</td>
            <td>{{ substr($documento['data_inicial'], 0, 4) }} - {{ substr($documento['data_final'], 0, 4) }}</td>
            <td>{{ $documento['observacoes'] }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" height="10">Data da assinatura do Termo de Entrega e Recebimento: </td>
        </tr>
        <tr>
            <td colspan="4" height="20">Nome, cargo, matrícula e assinatura do servidor do órgão ou entidade responsável pela trasferência ou recolhimento do acervo: </td>
        </tr>
    </tbody>
</table>