"use strict";
function MostrarDatos() {
    var valor_1 = parseInt(document.getElementById("valor_1").value);
    var valor_2 = parseInt(document.getElementById("valor_2").value);
    var operador = (document.querySelectorAll('input[name="rdoVoto"]'));
    /*
            -(suma,resta, multiplicación y división).
            
            Cuando se pulsa el botón una función deberá mostrar el
            resultado (en la consola y en otro cuadro de texto), de acuerdo al tipo de operación que el
            usuario eligió. Utilizar la estructura ‘switch’.
    */
    switch (operacion(operador)) {
        case "+":
            suma(valor_1, valor_2);
            break;
        case "-":
            resta(valor_1, valor_2);
            break;
        case "*":
            multiplicar(valor_1, valor_2);
            break;
        case "/":
            dividir(valor_1, valor_2);
            break;
        default:
            break;
    }
}
function suma(valor_1, valor_2) {
    alert("La suma de " + valor_1 + " y " + valor_2 + " es : " + (valor_1 + valor_2));
}
function resta(valor_1, valor_2) {
    alert("La resta de " + valor_1 + " y " + valor_2 + " es : " + (valor_1 - valor_2));
}
function multiplicar(valor_1, valor_2) {
    alert("La multiplicacion de " + valor_1 + " y " + valor_2 + " es : " + (valor_1 * valor_2));
}
function dividir(valor_1, valor_2) {
    alert("La division de " + valor_1 + " y " + valor_2 + " es : " + (valor_1 / valor_2));
}
function operacion(Operador) {
    var rta = "null";
    if (Operador != null) {
        for (var i = 0; i < Operador.length; i++) {
            if (Operador[i].checked) {
                rta = Operador[i].value;
                break;
            }
        }
    }
    return rta;
}
//# sourceMappingURL=ejercicio_21.js.map