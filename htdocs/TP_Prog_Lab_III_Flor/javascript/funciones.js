function AdministrarValidaciones() {
    var dni = document.getElementById("txtDni").value;
    var apellido = document.getElementById("txtApellido").value;
    var nombre = document.getElementById("txtNombre").value;
    var sexo = document.getElementById("cboSexo").value;
    var legajo = document.getElementById("txtLegajo").value;
    var sueldo = document.getElementById("txtSueldo").value;
    var sueldoMax = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
    if (!ValidarCamposVacios(dni)
        || !ValidarCamposVacios(apellido)
        || !ValidarCamposVacios(nombre)
        || !ValidarCamposVacios(sueldo)
        || !ValidarCamposVacios(legajo)
        || ValidarCombo(sexo, "---")) {
        alert("Uno o varios campos se encuentran sin completar");
    }
    if (!ValidarRangoNumerico(parseInt(sueldo), 8000, sueldoMax)) {
        alert("El sueldo no se encuentra dentro de los limites");
    }
    else {
        if (!((parseInt(sueldo) % 2) == 0)) {
            alert("Ingrese sueldo correcto");
        }
    }
    if (!ValidarRangoNumerico(parseInt(dni), 1000000, 55000000)) {
        alert("El dni no se encuentra dentro de los limites");
    }
    if (!ValidarRangoNumerico(parseInt(legajo), 100, 550)) {
        alert("El legajo no se encuentra dentro de los limites");
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
