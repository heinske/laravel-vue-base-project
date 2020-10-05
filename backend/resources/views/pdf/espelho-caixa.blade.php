<div style="width: 11cm; height: 16cm; border: 1px solid black; ">
    <div style="border-bottom: 1px solid black; height: 2.4cm;">
        <div style="float: left; width: 20%; height: 1.5cm;">
            <img src="/var/www/html/public/images/brasao.png" style="width: 90px; height: 2.39cm;"/>
        </div>
        <div style="float: left; width: 70%; text-align: center; height: 1.5cm; font-size: 18px; margin-left: 15px; font-family: Arial;">
            <strong>MINISTÉRIO DA MULHER, DA FAMÍLIA E DOS DIREITOS HUMANOS</strong>
        </div>
    </div>
    <div style="border-bottom: 1px solid black; height: 0.6cm; text-align: center;">
        {{ $caixa['procedencia'] }}
    </div>
    <div style="font-size: 14px; border-bottom: 1px solid black; height: 8cm; text-align: left; padding-left: 10px; padding-top: 10px;">                
        @foreach($classificacoes as $classificacao)
            {{ $classificacao }}<br>
        @endforeach
    </div>
    <div style="border-bottom: 1px solid black; height: 1cm; text-align: left;">
        <div style="border-right: 1px solid black; width: 20%; float:left; text-align: center;"><strong>Datas-Limite</strong></div>
        <div style="width: 70%; float:left; text-align: center;  padding-top: 9px;"><strong>Prazos de Guarda</strong></div>
    </div>
    <div style="border-bottom: 1px solid black; height: 2cm; text-align: left;">

        @if($caixa['ano_limite_inicio'] != $caixa['ano_limite_fim'] && $caixa['ano_limite_inicio'] != 0 && $caixa['ano_limite_fim'] != 0)
            <div style="border-right: 1px solid black; width: 20%; height: 2cm; float:left; text-align: center;">{{ $caixa['ano_limite_inicio'] }} - {{ $caixa['ano_limite_fim'] }}</div>
        @elseif($caixa['ano_limite_inicio'] == $caixa['ano_limite_fim'])
            <div style="border-right: 1px solid black; width: 20%; height: 2cm; float:left; text-align: center;">{{ $caixa['ano_limite_inicio'] }}</div>
        @elseif($caixa['ano_limite_fim'] != $caixa['ano_limite_fim'] && $caixa['ano_limite_inicio'] == 0)
            <div style="border-right: 1px solid black; width: 20%; height: 2cm; float:left; text-align: center;">{{ $caixa['ano_limite_fim'] }}</div>
        @else
            <div style="border-right: 1px solid black; width: 20%; height: 2cm; float:left; text-align: center;">{{ $caixa['ano_limite_inicio'] }}</div>
        @endif

        <div style="border-right: 1px solid black; width: 79.5%;  height: 2cm; float:right; text-align: center;">
            <div style="border-bottom: 1px solid black; width: 100%;  height: 1cm; text-align: left;">
                <div style="border-right: 1px solid black; width: 115px;  height: 1cm; text-align: left; float: left; font-size: 17px; text-align: center;">Corrente</div>
                <div style="border-right: 1px solid black; width: 100px;  height: 1cm; text-align: left; float: left;  margin-left: 115px; font-size: 17px; text-align: center; ">Intermediário</div>
                <div style="width: 118px;  height: 1cm; text-align: left; float: left;  margin-left: 215px;  font-size: 17px; text-align: center;">Destinação <br> Final </div>
            </div>
            <div style="width: 100%;  height: 1cm; text-align: left;">
            <div style="border-right: 1px solid black; width: 115px;  height: 1cm; text-align: left; float: left; font-size: 15px; text-align: center;">{{ $anoCorrente }}</div>
                <div style="border-right: 1px solid black; width: 100px;  height: 1cm; text-align: left; float: left;  margin-left: 115px; font-size: 15px; text-align: center; ">{{ $anoIntermediario }}</div>
                <div style="width: 118px;  height: 1cm; text-align: left; float: left;  margin-left: 215px;  font-size: 15px; text-align: center;">{{ $destinacaoFinal }}</div>
            </div>
        </div>
    </div>
    <div style="height: 2cm; text-align: center; font-size: 22px; padding-top: 15px;">
        <strong>{{ $caixa['codigo'] }}</strong>
    </div>


</div>