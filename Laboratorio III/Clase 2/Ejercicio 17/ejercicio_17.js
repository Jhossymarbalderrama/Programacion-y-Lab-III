"use strict";
function MostrarDatos() {
    var elemento = (document.querySelectorAll('input[name="pelicula"]'));
    var flag = 0;
    console.log("-----------------------------------------------------");
    console.log("Peliculas Seleccionadas:");
    if (elemento != null) {
        for (var i = 0; i < elemento.length; i++) {
            if (elemento[i].checked) {
                console.log("Pelicula: " + elemento[i].value);
            }
        }
    }
}
//# sourceMappingURL=ejercicio_17.js.map