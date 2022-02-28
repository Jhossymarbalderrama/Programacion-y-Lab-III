"use strict";
function MostrarMails() {
    var x = document.getElementById("cboMail");
    for (var index = 0; index < x.options.length; index++) {
        if (x.options[index].selected == true) {
            alert(x.options[index].value);
        }
    }
}
//# sourceMappingURL=ejercicio_19.js.map