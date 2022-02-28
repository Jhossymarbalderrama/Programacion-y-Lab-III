"use strict";
///<reference path="ajax.ts" />
window.onload = function () {
    Main.MostrarAltayMostrar();
};
function AltaEmployee() {
    Main.CargarEmpleado();
}
var Main;
(function (Main) {
    function MostrarAltayMostrar() {
        MostrarGrilla();
        MostrarGrillaAlta();
    }
    Main.MostrarAltayMostrar = MostrarAltayMostrar;
    function MostrarGrilla() {
        var ajax = new Ajax();
        ajax.Post("./BackEnd/mostrar.php", MostrarGrillaSuccess);
    }
    Main.MostrarGrilla = MostrarGrilla;
    function MostrarGrillaAlta() {
        var ajax = new Ajax();
        ajax.Post("./index.php", MostrarAltaEmpleadosSuccess);
    }
    Main.MostrarGrillaAlta = MostrarGrillaAlta;
    function MostrarGrillaSuccess(grilla) {
        console.clear();
        console.log(grilla);
        document.getElementById("idMostrarEmpleados").innerHTML = grilla;
    }
    Main.MostrarGrillaSuccess = MostrarGrillaSuccess;
    function MostrarAltaEmpleadosSuccess(grilla) {
        console.clear();
        console.log(grilla);
        document.getElementById("idAltaEmpleado").innerHTML = grilla;
    }
    //fx q reciba legajo, eliminar elemenpleado se llama desde el mostrar
    function EliminarEmpleado(legajo) {
        var ajax = new Ajax();
        var parametro = ("txtLegajo=" + legajo);
        var path = "./BackEnd/eliminar.php";
        ajax.Get(path, MostrarAltayMostrar, parametro);
    }
    Main.EliminarEmpleado = EliminarEmpleado;
    function ModificarEmpleado(dni) {
        var ajax = new Ajax();
        var parametro = ("hiddenModificar=" + dni);
        ajax.Post("./index.php", MostrarAltaEmpleadosSuccess, parametro);
    }
    Main.ModificarEmpleado = ModificarEmpleado;
    function CargarEmpleado() {
        //Agarro los datos del index, hago un formulario y lo envio a admnistracion.php
        var dni = document.getElementById("txtDni").value;
        var apellido = document.getElementById("txtApellido").value;
        var nombre = document.getElementById("txtNombre").value;
        var sexo = document.getElementById("cboSexo").value;
        var legajo = document.getElementById("txtLegajo").value;
        var sueldo = document.getElementById("txtSueldo").value;
        var turno = ObtenerTurnoSeleccionado();
        var pathFoto = document.getElementById("pathFoto").files;
        var modificar = document.getElementById("hdnModificar").value;
        var formulario = new FormData();
        formulario.append("txtDni", dni);
        formulario.append("txtApellido", apellido);
        formulario.append("txtNombre", nombre);
        formulario.append("cboSexo", sexo);
        formulario.append("txtLegajo", legajo);
        formulario.append("txtSueldo", sueldo);
        formulario.append("rdoTurno", turno);
        formulario.append("pathFoto", pathFoto[0]);
        formulario.append("hdnModificar", modificar);
        AltaEmpleado(formulario);
    }
    Main.CargarEmpleado = CargarEmpleado;
    function AltaEmpleado(formulario) {
        var ajax = new Ajax();
        ajax.Post("../../TP_Prog_Lab_III_Flor/BackEnd/administracion.php", MostrarGrilla, formulario);
    }
    function Fail(retorno) {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!");
    }
})(Main || (Main = {}));
//# sourceMappingURL=app.js.map