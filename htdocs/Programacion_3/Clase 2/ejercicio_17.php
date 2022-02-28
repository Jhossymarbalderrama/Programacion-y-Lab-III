<?php
/*
Aplicación No 17 (Invertir palabra)
    Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La función
    validará que la cantidad de caracteres que tiene $palabra no supere a $max y además deberá
    determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
    “Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
    1 si la palabra pertenece a algún elemento del listado.
    0 en caso contrario.
*/
    function funcion_1($palabra,$max){
        $cant_ = strlen($palabra);
        $rta = 0;

        if($cant_ <= $max){
            switch ($palabra) {
                case "Recuperatorio":
                    echo "La cant de caracteres es $cant_ y la palabra es $palabra";
                    $rta = 1;
                    break;
                case "Parcial":
                    echo "La cant de caracteres es $cant_ y la palabra es $palabra";
                    $rta = 1;
                    break;
                case "Programacion":
                    echo "La cant de caracteres es $cant_ y la palabra es $palabra";
                    $rta = 1;
                    break;
                default:
                    echo "La cant de caracteres es $cant_ pero no coincide con las palabras en el listado";
                    break;
            }
        }else{
            echo "La palabra $palabra supera el maximo de caracteres que es $max";
        }
        return $rta;
    }

    echo "<br>El valor de retorno es ".funcion_1("Parcial",13);



?>