<?php
    require_once 'global.php';

    try {

        $salario = $_POST['salario'];
        $cestaBasica = $_POST['cestaBasica'];
        $inss = $_POST['inss'];
        $irrf = $_POST['irrf'];
        
        

        function limpaValores($valor)
        {
            $valor = trim($valor);
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", "", $valor);
            return $valor;
        }

        $salarioLimpo = floatval(limpaValores($salario));
        $cestaBasicaLimpa = floatval(limpaValores($cestaBasica));
        $inssLimpo = floatval(limpaValores($inss));
        $irrfLimpo = floatval(limpaValores($irrf));

        $total = $salarioLimpo + $cestaBasicaLimpa - $inssLimpo - $irrfLimpo;
        echo $total;
        
       //header('Location: produtos.php');

    } catch (Exception $e) {
        Erro::trataErro($e);
    }