"use strict";
/*
11. Definir una función que determine si la cadena de texto que se le pasa como parámetro
    es un palíndromo, es decir, si se lee de la misma forma desde la izquierda y desde la
    derecha. Ejemplo de palíndromo complejo: "La ruta nos aporto otro paso natural".
*/
function determinar_polindromo(cadena) {
    var cadena_M = cadena.toLowerCase();
    var cadena_invertida = cadena.split("").reverse().join("");
    var esDistinto = false;
    for (var i = 0; i < cadena.length; i++) {
        if (cadena_M.charAt(i) != cadena_invertida.charAt(i)) {
            esDistinto = true;
            break;
        }
    }
    if (esDistinto == false) {
        console.log("Son Iguales");
    }
    else {
        console.log("Son Distintos");
    }
}
determinar_polindromo("hojo");
//Test reverse
/*
var palabra = "hola";
var palabraInvertida = palabra.split("").reverse().join("");
console.log(palabra,palabraInvertida);
*/ 
