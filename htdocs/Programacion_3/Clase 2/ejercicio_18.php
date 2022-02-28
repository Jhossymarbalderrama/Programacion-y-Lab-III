<?php
/*
Aplicación No 18 (Par e impar)
    Crear una función llamada EsPar que reciba un valor entero como parámetro y devuelva TRUE si
    este número es par ó FALSE si es impar.
    Reutilizando el código anterior, crear la función EsImpar.
*/

    function esPar($entero){
        $rta = false;

        if($entero%2 == 0){
            $rta = true;
        }

        return $rta;
    }

    function esImpar($entero){
        return !(esPar($entero));
    }

    $valor = 5;

    echo"<h3>FUNCION - PAR , numero $valor</h3>";
    if(esPar($valor)){
        echo "El numero es Par <br>";
    }

    echo"<h3>FUNCION - IMMPAR, numero $valor</h3>";
    if(esImpar($valor)){
        echo "El numero es Impar <br>";
    }

    
?>