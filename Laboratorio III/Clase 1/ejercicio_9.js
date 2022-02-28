"use strict";
/*
9. Realizar una función que solicite (por medio de un parámetro) un número. Si el número
    es positivo, se mostrará el factorial de ese número, caso contrario se mostrará el cubo de
    dicho número.
    Nota: Reutilizar la función que determina el factorial de un número y la que calcula el
    cubo de un número.
*/
function funcion_cubo(valor) {
    return Math.pow(valor, 3);
}
function calculo_factorial_9(valor_1) {
    var total = 1;
    for (var i = 1; i <= valor_1; i++) {
        total = total * i;
    }
    return total;
}
function funcion_9(valor_n) {
    if (valor_n > 0) {
        console.log(calculo_factorial_9(valor_n));
    }
    else {
        console.log(funcion_cubo(valor_n));
    }
}
funcion_9(4);
