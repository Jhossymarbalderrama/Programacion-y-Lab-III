"use strict";
/// <reference path="./ajax.ts" />
var Test_eje7;
(function (Test_eje7) {
    function obtenerDatoJSON() {
        var pagina = "./traerAutoPHP.php";
        var ajax = new Ajax();
        ajax.Post(pagina, function (resultado) {
            alert(resultado);
        }, "", Fail);
    }
    Test_eje7.obtenerDatoJSON = obtenerDatoJSON;
    function Fail(retorno) {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }
})(Test_eje7 || (Test_eje7 = {}));
//# sourceMappingURL=manejador.js.map