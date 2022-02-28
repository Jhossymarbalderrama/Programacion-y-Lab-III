"use strict";
var Test;
(function (Test) {
    function ejercicio_2() {
        console.clear();
        var cadJSON = '[{ "codigoBarra" : 1012214511412141224552, "nombre" : "Dulce de Leche", "precio" : "$120"},{ "codigoBarra" : 1012548811412611424552, "nombre" : "Yerba", "precio" : "$350"},{ "codigoBarra" : 1012284441412141952252, "nombre" : "Don Satur", "precio" : "$90"}]';
        var productosJSON = JSON.parse(cadJSON);
        for (var i = 0; i < productosJSON.length; i++) {
            console.log(productosJSON[i].codigoBarra + " - " + productosJSON[i].nombre + " - " + productosJSON[i].precio);
            alert(productosJSON[i].codigoBarra + " - " + productosJSON[i].nombre + " - " + productosJSON[i].precio);
        }
    }
    Test.ejercicio_2 = ejercicio_2;
})(Test || (Test = {}));
//# sourceMappingURL=manejador.js.map