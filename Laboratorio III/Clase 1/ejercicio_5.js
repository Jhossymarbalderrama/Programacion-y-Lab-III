"use strict";
/*
    Guardar su nombre y apellido en dos variables distintas. Dichas variables serán pasadas
    como parámetro de la función MostrarNombreApellido, que mostrará el apellido en
    mayúscula y el nombre solo con la primera letra en mayúsculas y el resto en minúsculas.
    El apellido y el nombre se mostrarán separados por una coma (,).
    Nota: Utilizar console.log()
 */
var nombre = "";
var apellido = "";
function mostrarNombreApellido(nombre, apellido) {
    var nombreMay = nombre.charAt(0).toUpperCase() + nombre.slice(1).toLowerCase();
    console.log(apellido.toUpperCase() + "," + nombreMay);
}
mostrarNombreApellido("jhossy", "balderrama");
