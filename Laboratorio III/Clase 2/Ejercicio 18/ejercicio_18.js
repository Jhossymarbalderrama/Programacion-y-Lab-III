"use strict";
function MostrarVoto() {
    var nombre = document.getElementById("textNombre").value;
    var elemento = (document.querySelectorAll('input[name="rdoVoto"]'));
    var flag = 0;
    console.log("-----------------------------------------------------");
    console.log("Nombre: " + nombre);
    if (elemento != null) {
        for (var i = 0; i < elemento.length; i++) {
            if (elemento[i].checked) {
                console.log("Voto: " + elemento[i].value);
            }
        }
    }
}
//# sourceMappingURL=ejercicio_18.js.map