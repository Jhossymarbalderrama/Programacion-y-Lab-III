<?php
/*
    Aplicación No 15 (Potencias de números)
    Mostrar por pantalla las primeras 4 potencias de los números del uno 1 al 4 (hacer una función que
    las calcule invocando la función pow).
 */

    function potencia_($numero,$potencia){
        return pow($numero,$potencia);
    }

    for($i = 1; $i<=4;$i++){
        echo("<h2><b>Potencias de $i </b></h2>");
        for($j = 1; $j<=4;$j++){
            echo("Numero: $i, Potencia: " . potencia_($i,$j) . "<br>");
        }
    }

?>