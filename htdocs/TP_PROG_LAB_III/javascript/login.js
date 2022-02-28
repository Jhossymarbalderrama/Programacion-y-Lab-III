"use strict";
function AdministrarValidacionesLogin() {
    VerificarValidacionesLogin();
}
function AdministrarSpanError(id, elemento) {
    var spanID = document.getElementById(id);
    if (elemento) {
        spanID.style.display = "block";
    }
    else {
        spanID.style.display = "none";
    }
}
function VerificarValidacionesLogin() {
    var dni = document.getElementById("dni").value;
    var apellido = document.getElementById("apellido").value;
    var rta = false;
    if (!(ValidarCamposVacios(dni.toString()))) {
        AdministrarSpanError("spanDni", true);
    }
    else {
        if (ValidarRangoNumerico(parseInt(dni), 1000000, 55000000)) {
            AdministrarSpanError("spanDni", false);
            rta = true;
        }
        else {
            AdministrarSpanError("spanDni", true);
        }
    }
    if (!ValidarCamposVacios(apellido)) {
        AdministrarSpanError("spanApellido", true);
        rta = false;
    }
    else {
        AdministrarSpanError("spanApellido", false);
        rta = true;
    }
    return rta;
}
//# sourceMappingURL=login.js.map