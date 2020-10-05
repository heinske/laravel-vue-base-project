<?php
namespace App\Helpers;

/**
 * Classe de utilitários para o sistema
 * @author Ezequiel Lafuente <ezequiel.coelho@jointecnologia.com.br>
 */
class UtilHelper {

    /**
     * @param $cpf
     * @return null|string|string[]
     * @info Essa função serve para formatar o cpf que vêm do banco desformatado
     */
    public static function formatarCPF ($cpf) {

        if (strlen(preg_replace("/\D/", '', $cpf)) === 11) {
            $response = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
        } else {
            $response = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cpf);
        }

        return $response;
    }

    /**
     * @param $tel
     * @return string
     * @info Essa função serve para formatar o telefone que vêm do banco desformatado
     */
    public static function formatarTelefone($tel) {
        $tam = strlen(preg_replace("/[^0-9]/", "", $tel));
        if ($tam == 13) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
            return "+".substr($tel,0,$tam-11)." (".substr($tel,$tam-11,2).") ".substr($tel,$tam-9,5)."-".substr($tel,-4);
        }
        if ($tam == 12) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
            return "+".substr($tel,0,$tam-10)." (".substr($tel,$tam-10,2).") ".substr($tel,$tam-8,4)."-".substr($tel,-4);
        }
        if ($tam == 11) { // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
            return " (".substr($tel,0,2).") ".substr($tel,2,5)."-".substr($tel,7,11);
        }
        if ($tam == 10) { // COM CÓDIGO DE ÁREA NACIONAL
            return " (".substr($tel,0,2).") ".substr($tel,2,4)."-".substr($tel,6,10);
        }
        if ($tam <= 9) { // SEM CÓDIGO DE ÁREA
            return substr($tel,0,$tam-4)."-".substr($tel,-4);
        }
    }

    /**
     * @param $valor
     * @return mixed|string
     * @info Essa função serve para remover formatação de cep
     */
    public static function formatarCep($valor){
        return  substr($valor, 0, 5) . '-' . substr($valor, 5, 3);
    }

    /**
     * @param $valor
     * @return mixed|string
     * @info Essa função serve para remover formatação de cpf/cnpj
     */
    public static function limparCpfCnpj($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }


    public static function verificarIdade($born, $compare = null){
        $born = explode('-', date('d-m-Y', $born));
        $compare = explode('-', date('d-m-Y', empty($compare)? time(): $compare));
        $age = $compare[2] - $born[2];
        if($compare[1] > $born[1]) return $age;
        if($compare[1] == $born[1] && $compare[0] > $born[0]) return $age;
        return --$age;
    }

    public static function mask ($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
            if($mask[$i] == '#')
            {
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else
            {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    /**
     * @param $cpf
     * @return bool
     * @info Valida o cpf
     */
    public static function validarCpf($cpf)
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

}
