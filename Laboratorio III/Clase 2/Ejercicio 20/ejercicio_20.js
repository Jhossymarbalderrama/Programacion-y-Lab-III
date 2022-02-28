"use strict";
function HabilitarFormulario() {
    var password = "jhossy";
    var textPassword = document.getElementById("textPassword").value;
    if (textPassword === password) {
        alert("Contraseña Correcta...");
        document.getElementById("algo").disabled = false;
        document.getElementById("favcolor").disabled = false;
        document.getElementById("bday").disabled = false;
        document.getElementById("mesanio").disabled = false;
        document.getElementById("email").disabled = false;
        document.getElementById("lenguajes").disabled = false;
        document.getElementById("calificacion").disabled = false;
        document.getElementById("horario").disabled = false;
        document.getElementById("web").disabled = false;
        document.getElementById("bestday").disabled = false;
        document.getElementById("listaBrowser").disabled = false;
        document.getElementById("p1").disabled = false;
        document.getElementById("p2").disabled = false;
        document.getElementById("p3").disabled = false;
        document.getElementById("p4").disabled = false;
        document.getElementById("p5").disabled = false;
        document.getElementById("v1").disabled = false;
        document.getElementById("v2").disabled = false;
        document.getElementById("v3").disabled = false;
        document.getElementById("v4").disabled = false;
        document.getElementById("cboMail").disabled = false;
        document.getElementById("btnLimpiar").disabled = false;
        document.getElementById("btnEnviar").disabled = false;
    }
    else {
        alert("Contraseña incorrecta. Pruebe de nuevo...");
    }
}
//# sourceMappingURL=ejercicio_20.js.map