<?php
/*
    Aplicación No 16 (Invertir palabra)
    Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden de las
    letras del Array.
    Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.
*/

//var cadena_invertida = cadena.split("").reverse().join("");

    function invertir($array = array()){
        $reversed = array_reverse($array);

        print_r($reversed);
    }

    $array_cadena = array("H","O","L","A");
    echo"<h3>Array sin invertir</h3>";
    print_r($array_cadena);
    echo"<br>";
    echo"<h3>Array invertido</h3>";
    invertir($array_cadena);

?>