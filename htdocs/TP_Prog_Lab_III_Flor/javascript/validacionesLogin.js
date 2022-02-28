"use strict";
function AdministrarValidacionesLogin() {
    if (!VerificarValidacionesLogin()) {
        alert("Error");
    }
}
/*
Es la encargada de, según el parámetro
booleano, ocultar o no al elemento cuyo id coincida con el parámetro de tipo string.
 */
function AdministrarSpanError(cadena, booleano) {
    var spanId = document.getElementById(cadena);
    if (booleano) {
        spanId.style.display = "block";
    }
    else {
        spanId.style.display = "none";
    }
}
/**
 VerificarValidacionesLogin(): boolean. Deberá determinar si todos los campos del formulario
están validados. Retornará true, si ningún <span> posee display:block como valor del atributo
style, false caso contrario.
 */
function VerificarValidacionesLogin() {
    var retorno = true;
    var dni = document.getElementById("txtDni").value;
    var apellido = document.getElementById("txtApellido").value;
    if (!ValidarCamposVacios(dni) || !ValidarCamposVacios(apellido)) {
        alert("Uno o varios campos se encuentran sin completar");
        AdministrarSpanError("spanDni", true);
        AdministrarSpanError("spanApellido", true);
        if (!ValidarRangoNumerico(parseInt(dni), 1000000, 55000000)) {
            alert("El dni no se encuentra dentro de los limites");
        }
    }
    else {
        retorno = true;
    }
    return retorno;
}
//# sourceMappingURL=validacionesLogin.js.map