"use strict";
/// <reference path="./ajax.ts" />
var Test_eje6;
(function (Test_eje6) {
    function ejercicio_6() {
        var pagina = "./recibirJson.php";
        var ajax = new Ajax();
        ajax.Post(pagina, function (resultado) {
            document.getElementById("divResultado").innerHTML = "";
            console.clear();
            console.log(resultado);
            /*let objJson = JSON.parse(resultado);
            alert(objJson.codigoBarra + " - "+objJson.nombre + " - " + objJson.precio);
            console.log(objJson.codigoBarra + " - "+objJson.nombre + " - " + objJson.precio);*/
            alert(resultado);
        }, "", Fail);
    }
    Test_eje6.ejercicio_6 = ejercicio_6;
    function Fail(retorno) {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }
    Test_eje6.Fail = Fail;
    function IrHacia(pagina) {
        window.location.href = pagina;
    }
    Test_eje6.IrHacia = IrHacia;
})(Test_eje6 || (Test_eje6 = {}));
//# sourceMappingURL=manejador.js.map