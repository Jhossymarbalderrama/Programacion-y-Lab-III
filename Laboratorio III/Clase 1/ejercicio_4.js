"use strict";
/*
4. Realizar una función que reciba un número y que muestre (por consola) un mensaje
    como el siguiente:
    El número 5 es impar, siendo 5 el número recibido como parámetro.
*/
function funcion_test_2(valor) {
    if (valor % 2 != 0) {
        console.log("El numero " + valor + " es impar");
    }
    else {
        console.log("Es Par");
    }
}
funcion_test_2(5);
