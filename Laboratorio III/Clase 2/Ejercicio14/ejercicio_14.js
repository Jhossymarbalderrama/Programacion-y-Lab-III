"use strict";
function Saludar() {
    var dato_1 = document.getElementById("text1").value;
    var dato_2 = document.getElementById("text2").value;
    var dato_3 = document.getElementById("text3").value;
    var dato_4 = document.getElementById("text4").value;
    var dato_5 = document.getElementById("text5").value;
    var dato_6 = document.getElementById("text9").value;
    var dato_7 = document.getElementById("text13").value;
    var dato_8 = document.getElementById("text14").value;
    var dato_9 = document.getElementById("text15").value;
    var dato_10 = document.getElementById("text16").value;
    var dato_11 = document.getElementById("text8").value;
    var dato_12 = document.getElementById("text12").value;
    var lado_1 = Suma_Datos(dato_1, dato_2, dato_3, dato_4);
    var lado_2 = Suma_Datos(dato_1, dato_5, dato_6, dato_7);
    var lado_3 = Suma_Datos(dato_7, dato_8, dato_9, dato_10);
    var lado_4 = Suma_Datos(dato_4, dato_11, dato_12, dato_10);
    alert("Los lados son: Lado 1: " + lado_1 + "  - Lado 2: " + lado_2 + " - Lado 3: " + lado_3 + " - Lado 4: " + lado_4);
    alert("El perimetro es : " + (lado_1 + lado_2 + lado_3 + lado_4));
    document.getElementById("text6").value = "L1: " + lado_1;
    document.getElementById("text10").value = "L2: " + lado_2;
    document.getElementById("text7").value = "L3: " + lado_3;
    document.getElementById("text11").value = "L4: " + lado_4;
}
function Suma_Datos(value_1, value_2, value_3, value_4) {
    return parseInt(value_1) + parseInt(value_2) + parseInt(value_3) + parseInt(value_4);
}
//# sourceMappingURL=ejercicio_14.js.map