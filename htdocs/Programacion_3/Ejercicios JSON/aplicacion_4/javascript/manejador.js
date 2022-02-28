"use strict";
/// <reference path="./ajax.ts" />
var Test;
(function (Test) {
    function ejercicio_4() {
        var cadJSON = "[{ \"codigoBarra\" : 1012214511412141224552, \"nombre\" : \"Dulce de Leche\", \"precio\" : \"$120\"},\n                        { \"codigoBarra\" : 1012548811412611424552, \"nombre\" : \"Yerba\", \"precio\" : \"$350\"},\n                        { \"codigoBarra\" : 1012284441412141952252, \"nombre\" : \"Don Satur\", \"precio\" : \"$90\"}]";
        var pagina = "./backend/mostrarColeccionJson.php";
        var ajax = new Ajax();
        var params = "misProd=" + cadJSON;
        alert(params);
        ajax.Post(pagina, function (resultado) {
            console.log(resultado);
        }, params, Fail);
    }
    Test.ejercicio_4 = ejercicio_4;
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