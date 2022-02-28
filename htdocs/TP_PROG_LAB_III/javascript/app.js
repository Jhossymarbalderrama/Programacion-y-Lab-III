"use strict";
/// <reference path="ajax.ts" />
window.onload = function () {
    Main.RefrescarPaginaSuccess();
};
function AddEmployee() {
    Main.CargarDatos();
}
function DeleteEmployee(legajo) {
    Main.EliminarEmpleado(legajo);
}
function ModificarEmployee(dni) {
    Main.ModificarEmpleado(dni);
}
var Main;
(function (Main) {
    function RefrescarPaginaSuccess() {
        MostrarForm();
        MostrarEmpleados();
    }
    Main.RefrescarPaginaSuccess = RefrescarPaginaSuccess;
    function MostrarEmpleados() {
        var ajax = new Ajax();
        /* ajax.Post("../../TP_PROG_LAB_III/backend/mostrar.php",
        MostrarEmpleadosSuccess);   */
        ajax.Post("backend/mostrar.php", MostrarEmpleadosSuccess);
    }
    Main.MostrarEmpleados = MostrarEmpleados;
    function MostrarForm() {
        var ajax = new Ajax();
        /* ajax.Post("../../TP_PROG_LAB_III/index.php",
        MostrarFormSuccess); */
        ajax.Post("index.php", MostrarFormSuccess);
    }
    Main.MostrarForm = MostrarForm;
    function MostrarEmpleadosSuccess(empleados) {
        document.getElementById("divEmpleados").innerHTML = empleados;
    }
    Main.MostrarEmpleadosSuccess = MostrarEmpleadosSuccess;
    function MostrarFormSuccess(respuesta) {
        document.getElementById("divFrm").innerHTML = respuesta;
    }
    Main.MostrarFormSuccess = MostrarFormSuccess;
    function EliminarEmpleado(legajo) {
        var ajax = new Ajax();
        var parametros = "legajo=" + legajo;
        /* ajax.Get("../../TP_PROG_LAB_III/backend/eliminar.php",DeleteSuccess,parametros,Fail); */
        ajax.Get("backend/eliminar.php", DeleteSuccess, parametros, Fail);
    }
    Main.EliminarEmpleado = EliminarEmpleado;
    function DeleteSuccess(retorno) {
        console.clear();
        console.log(retorno);
        MostrarEmpleados();
    }
    Main.DeleteSuccess = DeleteSuccess;
    function Fail(retorno) {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    }
    Main.Fail = Fail;
    function ModificarEmpleado(dni) {
        var ajax = new Ajax();
        var parametros = "dniHidden=" + dni;
        ajax.Post("index.php", MostrarFormSuccess, parametros, Fail);
    }
    Main.ModificarEmpleado = ModificarEmpleado;
    function CargarDatos() {
        var dni = document.getElementById("textDNI").value;
        var nombre = document.getElementById("textNombre").value;
        var apellido = document.getElementById("textApellido").value;
        var sueldo = document.getElementById("textSueldo").value;
        var legajo = document.getElementById("textLegajo").value;
        var turno = ObtenerTurnoSeleccionado();
        var sexo = document.getElementById("cboSexo").value;
        var modificar = document.getElementById("hdnModificar").value;
        var foto = document.getElementById("file").files;
        var form = new FormData();
        form.append('file', foto[0]);
        form.append("nombre", nombre);
        form.append("dni", dni);
        form.append("apellido", apellido);
        form.append("sueldo", sueldo);
        form.append("legajo", legajo);
        form.append("rdoTurno", turno);
        form.append("sexo", sexo);
        form.append("hdnModificar", modificar);
        MandarEmpleado(form);
    }
    Main.CargarDatos = CargarDatos;
    var MandarEmpleado = function (form) {
        var ajax = new Ajax();
        ajax.Post("backend/administracion.php", MostrarEmpleadosSuccess, form, Fail);
    };
})(Main || (Main = {}));
//# sourceMappingURL=app.js.map