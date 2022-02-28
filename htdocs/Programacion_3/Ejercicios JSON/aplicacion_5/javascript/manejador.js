"use strict";
/// <reference path="./ajax.ts" />
var Test_eje5;
(function (Test_eje5) {
    function ejercicio_5() {
        var pagina = "./recibirJson.php";
        var ajax = new Ajax();
        ajax.Post(pagina, function (resultado) {
            document.getElementById("divResultado").innerHTML = "";
            console.clear();
            console.log(resultado);
            var objJson = JSON.parse(resultado);
            alert(objJson.codigoBarra + " - " + objJson.nombre + " - " + objJson.precio);
            console.log(objJson.codigoBarra + " - " + objJson.nombre + " - " + objJson.precio);
        }, "", Fail);
    }
    Test_eje5.ejercicio_5 = ejercicio_5;
    function Fail(retorno) {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }
    Test_eje5.Fail = Fail;
    function IrHacia(pagina) {
        window.location.href = pagina;
    }
    Test_eje5.IrHacia = IrHacia;
})(Test_eje5 || (Test_eje5 = {}));
//# sourceMappingURL=manejador.js.map