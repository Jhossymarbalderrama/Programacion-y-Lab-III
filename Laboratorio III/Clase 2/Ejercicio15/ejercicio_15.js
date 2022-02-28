"use strict";
function MostrarDato() {
    var nombre = document.getElementById("nombre").value;
    var pais = parseInt(document.getElementById("pais").value);
    alert("Su nombre es: " + nombre + " y su pais es: " + descripcion_Pais(pais));
}
function descripcion_Pais(numero) {
    var valor = "No se encontro pais";
    if (paises[numero] != null) {
        valor = paises[numero].toString();
    }
    return valor;
}
var paises;
(function (paises) {
    paises[paises["Argentina"] = 0] = "Argentina";
    paises[paises["Espa\u00F1a"] = 1] = "Espa\u00F1a";
    paises[paises["M\u00E9xico"] = 2] = "M\u00E9xico";
    paises[paises["Guatemala"] = 3] = "Guatemala";
    paises[paises["Honduras"] = 4] = "Honduras";
    paises[paises["El Salvador"] = 5] = "El Salvador";
    paises[paises["Venezuela"] = 6] = "Venezuela";
    paises[paises["Colombia"] = 7] = "Colombia";
    paises[paises["Cuba"] = 8] = "Cuba";
    paises[paises["Bolivia"] = 9] = "Bolivia";
    paises[paises["Ecuador"] = 10] = "Ecuador";
    paises[paises["Uruguay"] = 11] = "Uruguay";
})(paises || (paises = {}));
//# sourceMappingURL=ejercicio_15.js.map