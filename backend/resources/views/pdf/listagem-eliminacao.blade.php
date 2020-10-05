<style>
    .text-header { 
        font-size: 11px;
    }

    .text-body { 
        font-size: 11px;
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
    @page { size: A4 landscape }


</style>
<table border="1" cellspacing="0" style="width: 100%">
    <thead class="text-header">
        <tr>
            <td colspan="4">
                <strong>LISTAGEM DE ELIMINAÇÃO DE DOCUMENTOS</strong><br />
                <strong>ÓRGÃO / ENTIDADE: Ministério da Mulher, da Família e dos Direitos Humanos - MMFDH</strong><br />
                <strong>Unidade/Setor: Divisão de Gestão Documental - DIVGED</strong><br />
            </td>
            <td colspan="2">
                <strong>ÓRGÃO / SETOR: MMFDH / DIVGED</strong><br />
                <strong>Listagem nº: 01/2020 Folha nº: <span class="pagenum"></span></strong><br />
            </td>
        </tr>
        <tr class='text-center'>
            <td rowspan="2">
                <strong>Código referente à classificação</strong>
            </td>
            <td rowspan="2">
                <strong>Descritor do código</strong>
            </td>
            <td rowspan="2">
                <strong>Datas-limite</strong>
            </td>
            <td colspan="2">
                <strong>Unidade de Arquivamento</strong>
            </td>
            <td rowspan="2">
                <strong>Observações e/ou justificativas</strong>
            </td>
        </tr>
        <tr class='text-center'>
            <td>
                <strong>Quantidade</strong>
            </td>
            <td>
                <strong>Especificação</strong>
            </td>
        </tr>
    </thead>
    <tbody class='text-body'>
        @php $mensuracao = 0; $anoInicial = 0; $anoFinal = 0; @endphp
        @foreach($classificacoes as $classificacao)
            <tr>
                <td>{{ $classificacao['codigo'] }}</td>
                <td>{{ $classificacao['descricao'] }}</td>
                <td>
                    @foreach($classificacao['documentos'] as $key => $documento)
                        @php $dtInicio = (int) substr($documento['data_inicial'], 0, 4);  @endphp
                        @php $dtFinal  = (int) substr($documento['data_final'], 0, 4);    @endphp
                        @php $anoInicial = $anoInicial || $anoInicial == 0 > $dtInicio ? $dtInicio : $anoInicial; @endphp
                        @php $anoFinal = $anoFinal < $dtFinal ? $dtFinal : $anoFinal; @endphp

                        @if(count($classificacao['documentos']) == $key +1)
                            {{ substr($documento['data_inicial'], 0, 4) }} - {{ substr($documento['data_final'], 0, 4) }}
                        @else
                            {{ substr($documento['data_inicial'], 0, 4) }} - {{ substr($documento['data_final'], 0, 4) }} / 
                        @endif
                        
                        @foreach($documento['listagensEliminacao'] as $listagem)
                            @php $mensuracao += 0;  @endphp
                        @endforeach
                    @endforeach
                </td>
                <td>{{ count($classificacao['documentos']) }}</td>
                <td>Documentos</td>
                <td></td>
            </tr>
      
        @endforeach
        <tr>
            <td colspan="6">MENSURAÇÃO TOTAL: <strong>{{ $mensuracao }} metros lineares</strong></td>
        </tr>
        <tr>
            <td colspan="6">DATAS LIMITES GERAIS: {{ $anoInicial }} - {{ $anoFinal }}</td>
        </tr>
    </tbody>
</table>

<br><br>

<table style="width: 100%" border="1" cellspacing="0">
    <thead class="text-header text-center">
        <tr>
            <td width="30%">Conta(s) do(s) exercício(s) de:</td>
            <td width="30%">Conta(s) aprovada(s) pelo Tribunal de Contas em:</td>
            <td width="40%">Publicação no Diário Oficial (data, seção, página)</td>
        </tr>
    </thead>
    <tbody class="text-body">
        <tr>
            <td height="10"></td>
            <td height="10"></td>
            <td height="10"></td>
        </tr>
        <tr>
            <td height="10"></td>
            <td height="10"></td>
            <td height="10"></td>
        </tr>
        <tr>
            <td height="10"></td>
            <td height="10"></td>
            <td height="10"></td>
        </tr>
    </tbody>
</table>

<br>

<table style="width: 100%" border="1" cellspacing="0">
    <thead></thead>
    <tbody class="text-body">
        <tr width="100%">
            <td height="15">LOCAL/DATA:<br><br><br>________________________________________________________________________________________________________________<br>Responsável pela seleção:</td>
        </tr>
    </tbody>
</table>

<br>
<table style="width: 100%" border="1" cellspacing="0">
    <thead></thead>
    <tbody class="text-body">
        <tr width="100%">
            <td height="15">LOCAL/DATA:<br><br><br>________________________________________________________________________________________________________________<br>Responsável pela seleção:</td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%" border="1" cellspacing="0">
    <thead></thead>
    <tbody class="text-body">
        <tr width="100%">
            <td height="15" >LOCAL/DATA:<br><br><br>________________________________________________________________________________________________________________<br>Responsável pela seleção:</td>
        </tr>
    </tbody>
</table>
<br><br>
<table style="width: 100%" border="1" cellspacing="0">
    <thead class="text-body">
        <tr width="100%">
            <td height="15" >LOCAL/DATA:<br><br>AUTORIZO:<br><br><br>________________________________________________________________________________________________________________<br>TITULAR DO ÓRGÃO/ENTIDADE PRODUTOR / ACUMULADOR DO ARQUIVO</td>
        </tr>
    </thead>
</table>
