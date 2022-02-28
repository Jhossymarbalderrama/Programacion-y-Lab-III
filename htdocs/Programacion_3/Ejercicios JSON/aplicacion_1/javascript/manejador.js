"use strict";
var Test;
(function (Test) {
    function ejercicio_1() {
        console.clear();
        //objeto simple
        var persona = { "codigoBarra": 1012214511412141224552, "nombre": "Dulce de Leche", "precio": "$120" };
        alert("Codigo de barra: " + persona.codigoBarra + " - Nombre: " + persona.nombre + " - precio: " + persona.precio);
        console.log("Codigo de barra: " + persona.codigoBarra + " - Nombre: " + persona.nombre + " - precio: " + persona.precio);
        console.log("\n");
        console.log(persona["codigoBarra"] + " - " + persona["nombre"] + " - " + persona["precio"]);
    }
    Test.ejercicio_1 = ejercicio_1;
})(Test || (Test = {}));
//# sourceMappingURL=manejador.js.map