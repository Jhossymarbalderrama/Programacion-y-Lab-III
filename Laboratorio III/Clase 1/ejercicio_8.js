"use strict";
/*
    8. Crear una función que realice el cálculo factorial del número que recibe como parámetro.
    Nota: Utilizar console.log()
*/
function calculo_factorial(valor_1) {
    var total = 1;
    for (var i = 1; i <= valor_1; i++) {
        total = total * i;
    }
    console.log(total);
}
calculo_factorial(4);
