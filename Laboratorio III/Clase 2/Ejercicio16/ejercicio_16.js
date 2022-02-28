"use strict";
function MostrarDatos() {
    var nombre = document.getElementById("Nombre").value;
    var apellido = document.getElementById("Apellido").value;
    var dni = document.getElementById("DNI").value;
    var mail = document.getElementById("Mail").value;
    var curriculum = document.getElementById("Curriculum").value;
    console.log(toString(nombre, apellido, dni, curriculum, mail));
}
function toString(nombre, apellido, dni, curriculum, mail) {
    var detalles = "";
    detalles = detalles + "Nombre: " + nombre + "\n";
    detalles = detalles + "Apellidos: " + apellido + "\n";
    detalles = detalles + "DNI: " + dni + "\n";
    detalles = detalles + "Mail: " + mail + "\n";
    detalles = detalles + "Curriculum: " + curriculum + "\n";
    return detalles;
}
//# sourceMappingURL=ejercicio_16.js.map