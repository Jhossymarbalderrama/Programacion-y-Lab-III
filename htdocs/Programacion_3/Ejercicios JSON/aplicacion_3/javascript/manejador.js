"use strict";
/// <reference path="./ajax.ts" />
var Test;
(function (Test) {
    function ejercicio_3() {
        var cadJSON = { "codigoBarra": 1012214511412141224552, "nombre": "Dulce de Leche", "precio": "$120" };
        //let pagina = "../../../../Programacion_3/Ejercicios JSON/aplicacion_3/backend/mostrarJson.php";
        var pagina = "./backend/mostrarJson.php";
        var ajax = new Ajax();
        var params = "miProd=" + JSON.stringify(cadJSON);
        alert(params);
        ajax.Post(pagina, function (resultado) {
            console.log(resultado);
        }, params, Fail);
    }
    Test.ejercicio_3 = ejercicio_3;
    function Fail(retorno) {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }
    function IrHacia(pagina) {
        window.location.href = pagina;
    }
    Test.IrHacia = IrHacia;
})(Test || (Test = {}));
//# sourceMappingURL=manejador.js.map