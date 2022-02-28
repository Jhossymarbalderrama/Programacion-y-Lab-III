"use strict";
function AdministrarValidaciones() {
    var dni = document.getElementById("txtDni").value;
    var apellido = document.getElementById("txtApellido").value;
    var nombre = document.getElementById("txtNombre").value;
    var sexo = document.getElementById("cboSexo").value;
    var legajo = document.getElementById("txtLegajo").value;
    var sueldo = document.getElementById("txtSueldo").value;
    var sueldoMax = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
    var pathFoto = document.getElementById("pathFoto").value;
    if (!(ValidarCamposVacios(dni))) {
        AdministrarSpanError("spanDni", true);
    }
    else {
        if (ValidarRangoNumerico(parseInt(dni), 1000000, 55000000)) {
            AdministrarSpanError("spanDni", false);
        }
        else {
            AdministrarSpanError("spanDni", true);
        }
    }
    if (!(ValidarCamposVacios(apellido))) {
        AdministrarSpanError("spanApellido", true);
    }
    else {
        AdministrarSpanError("spanApellido", false);
    }
    if (!(ValidarCamposVacios(nombre))) {
        AdministrarSpanError("spanNombre", true);
    }
    else {
        AdministrarSpanError("spanNombre", false);
    }
    if ((ValidarCombo(sexo, "---"))) {
        AdministrarSpanError("spanSexo", true);
    }
    else {
        AdministrarSpanError("spanSexo", false);
    }
    if (!(ValidarCamposVacios(legajo))) {
        AdministrarSpanError("spanLegajo", true);
    }
    else {
        if (ValidarRangoNumerico(parseInt(legajo), 100, 550)) {
            AdministrarSpanError("spanLegajo", false);
        }
        else {
            AdministrarSpanError("spanLegajo", true);
        }
    }
    if (!(ValidarCamposVacios(sueldo))) {
        AdministrarSpanError("spanSueldo", true);
    }
    else {
        if (ValidarRangoNumerico(parseInt(sueldo), 100, sueldoMax)) {
            AdministrarSpanError("spanSueldo", false);
        }
        else {
            AdministrarSpanError("spansueldo", true);
        }
    }
    if (!(ValidarCamposVacios(pathFoto))) {
        AdministrarSpanError("spanFoto", true);
    }
    else {
        AdministrarSpanError("spanFoto", false);
    }
}
/**
 *
 * @param cadena
 * @returns
 */
function ValidarCamposVacios(cadena) {
    var retorno = false;
    if (cadena.length != 0) {
        retorno = true;
    }
    return retorno;
}
function ValidarRangoNumerico(numero, min, max) {
    var retorno = false;
    if (numero >= min && numero <= max) {
        retorno = true;
    }
    return retorno;
}
function ValidarCombo(elemento, sexo) {
    var retorno = false;
    if (elemento === sexo) {
        retorno = true;
    }
    return retorno;
}
function ObtenerTurnoSeleccionado() {
    var retorno = "";
    var turnos = document.getElementsByName("rdoTurno");
    for (var i = 0; i < turnos.length; i++) {
        if (turnos[i].checked) {
            retorno = turnos[i].value;
        }
    }
    return retorno;
}
function ObtenerSueldoMaximo(turno) {
    var sueldoMax = 0;
    switch (turno) {
        case "maniana":
            sueldoMax = 20000;
            break;
        case "tarde":
            sueldoMax = 18500;
            break;
        case "noche":
            sueldoMax = 25000;
            break;
        default:
            break;
    }
    return sueldoMax;
}
// La función AdministrarModificar deberá establecer el valor del input  (type=hidden) con el valor recibido como parametro y luego ‘submitear’ el formulario que lo contiene.
function AdministrarModificar(dni) {
    document.getElementById("hiddenModificar").value = dni;
    alert(dni);
    var formModificar = document.getElementById("frmModificar"); //tomar el fomulario por id
    formModificar.submit(); //Enviando el formulario 
}
//# sourceMappingURL=validaciones.js.map