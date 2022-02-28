"use strict";
/// <reference path="ajax.ts" />
window.onload = function () {
    Main.RefrescarPaginaSuccess();
};
var Main;
(function (Main) {
    Main.RefrescarPaginaSuccess = function () {
        console.clear();
        //console.log(respuesta);
        MostrarForm();
        Main.MostrarEmpleados();
    };
    Main.MostrarEmpleados = function () {
        var ajax = new Ajax();
        ajax.Post("./backend/mostrar.php", MostrarEmpleadosSuccess);
    };
    function MostrarForm() {
        var ajax = new Ajax();
        ajax.Post("./index.php", MostrarFormSuccess);
    }
    Main.MostrarForm = MostrarForm;
    Main.EliminarEmpleado = function (legajo) {
        var ajax = new Ajax();
        var parametros = "legajo=" + legajo;
        ajax.Get("./backend/eliminar.php", DeleteSuccess, parametros, Fail);
    };
    function MostrarEmpleadosSuccess(empleados) {
        console.clear();
        console.log(empleados);
        document.getElementById("divEmpleados").innerHTML = empleados;
    }
    Main.MostrarEmpleadosSuccess = MostrarEmpleadosSuccess;
    function MostrarFormSuccess(respuesta) {
        console.log(respuesta);
        document.getElementById("divFrm").innerHTML = respuesta;
    }
    Main.MostrarFormSuccess = MostrarFormSuccess;
    function DeleteSuccess(retorno) {
        console.clear();
        console.log(retorno);
        Main.MostrarEmpleados();
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
        var parametros = "dni=" + dni;
        ajax.Post("./index.php", MostrarFormSuccess, parametros, Fail);
    }
    Main.ModificarEmpleado = ModificarEmpleado;
    function CargarDatos() {
        /*
        let ajax = new Ajax();
        let dni: string = (<HTMLInputElement> document.getElementById("txtDni")).value;
        let nombre: string = (<HTMLInputElement> document.getElementById("txtNombre")).value;
        let apellido: string = (<HTMLInputElement> document.getElementById("txtApellido")).value;
        let sueldo: string = (<HTMLInputElement> document.getElementById("txtSueldo")).value;
        let legajo: string = (<HTMLInputElement> document.getElementById("txtLegajo")).value;
        let turno: string = ObtenerTurnoSeleccionado();
        let sexo: string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
        let archivo: FileList | null = (<HTMLInputElement>document.getElementById("file")).files;
        let modificar = (<HTMLInputElement>document.getElementById("hdnModificar")).value;

        let form: FormData = new FormData();

        //form.append('file', archivo[0]);
        form.append("txtNombre",nombre);
        form.append("txtDni",dni);
        form.append("txtApellido",apellido);
        form.append("txtSueldo",sueldo);
        form.append("txtLegajo",legajo);
        form.append("rdoTurno",turno);
        form.append("cboSexo",sexo);
        form.append("hdnModificar",modificar);

        MandarEmpleado(form);*/
    }
    Main.CargarDatos = CargarDatos;
    var MandarEmpleado = function (form) {
        var ajax = new Ajax();
        ajax.Post("./backend/administracion.php", Main.RefrescarPaginaSuccess, form, Fail);
    };
})(Main || (Main = {}));
//# sourceMappingURL=app.js.map