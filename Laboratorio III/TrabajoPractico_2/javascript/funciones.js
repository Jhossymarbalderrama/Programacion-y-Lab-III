function AdministrarValidaciones() {
    var dni = parseInt(document.getElementById("textDNI").value);
    var apellido = document.getElementById("textApellido").value;
    var nombre = document.getElementById("textNombre").value;
    var sexo = document.getElementById("cboSexo").value;
    var legajo = parseInt(document.getElementById("textLegajo").value);
    var sueldo = parseInt(document.getElementById("textSueldo").value);
    var datosPersona = new Array(dni.toString(), apellido, nombre, sexo, legajo.toString(), sueldo.toString());
    for (var index = 0; index < datosPersona.length; index++) {
        if (ValidarCamposVacios(datosPersona[index])) {
            switch (index) {
                case 0:
                    if (!(ValidarRangoNumerico(dni, 1000000, 55000000))) {
                        alert("Ingrese un DNI correcto");
                    }
                    break;
                case 1:
                    //Este campo se valida en el primer if (Solo que no este vacio)
                    break;
                case 2:
                    //Este campo se valida en el primer if (Solo que no este vacio)
                    break;
                case 3:
                    //SEXO
                    if (ValidarCombo(sexo, "M") || ValidarCombo(sexo, "F")) {
                        //Sexo correcto M o F
                    }
                    else {
                        alert("Ingrese un Sexo Correcto");
                    }
                    break;
                case 4:
                    if (!(ValidarRangoNumerico(legajo, 100, 550))) {
                        alert("Ingrese un LEGAJO Correcto");
                    }
                    break;
                case 5:
                    if (!(ValidarRangoNumerico(sueldo, 8000, ObtenerSueldoMaximo(ObtenerTurnoSeleccionado())))) {
                        alert("Ingrese un SUELDO Correcto");
                    }
                    else {
                        if (!((sueldo % 2) == 0)) {
                            alert("Ingrese un SUELDO Correcto");
                        }
                    }
                    break;
            }
        }
        else {
            if (ValidarCombo(sexo, "")) {
                alert("Ingrese un Sexo");
            }
        }
    }
}
/**
 * Recibe el valor ID de un campo y lo valido que no este vacio
 *
 * @param cadena
 * @returns True si no esta vacio o False caso contrario
 */
function ValidarCamposVacios(cadena) {
    var rta = false;
    if (cadena.length > 0) {
        rta = true;
    }
    return rta;
}
/**
 * Recibe como parametro el valor a ser validado y los valores min y max del rango
 *
 * @param valor_n
 * @param min_n
 * @param max_n
 * @returns Retorna true si el valor pertenece al rango o false caso contrario
 */
function ValidarRangoNumerico(valor_n, min_n, max_n) {
    var rta = false;
    if (valor_n > 0) {
        if (valor_n >= min_n && valor_n <= max_n) {
            rta = true;
        }
    }
    return rta;
}
/**
 * Recibe como parámetro el valor del atributo id del combo a ser validado y el valor que no debe de tener
 *
 * @param cadena_s
 * @param sexo_s
 * @returns Retorna true si no coincide o false caso contrario
 */
function ValidarCombo(cadena_s, sexo_s) {
    var rta = false;
    //M o F
    if (cadena_s === sexo_s) {
        rta = true;
    }
    return rta;
}
function ObtenerTurnoSeleccionado() {
    var elemento = (document.querySelectorAll('input[name="rdoTurno"]'));
    var flag = 0;
    var rta = "";
    if (elemento != null) {
        for (var i = 0; i < elemento.length; i++) {
            if (elemento[i].checked) {
                rta = elemento[i].value;
            }
        }
    }
    return rta;
}
function ObtenerSueldoMaximo(turno_v) {
    var valor_Maximo = 0;
    switch (turno_v) {
        case "Mañana":
            valor_Maximo = 20000;
            break;
        case "Tarde":
            valor_Maximo = 18500;
            break;
        case "Noche":
            valor_Maximo = 25000;
            break;
    }
    return valor_Maximo;
}
