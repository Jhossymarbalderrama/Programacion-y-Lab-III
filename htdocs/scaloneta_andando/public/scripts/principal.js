"use strict";
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var APIREST = "http://scaloneta/";
$(function () {
    $("#usuarios").on("click", function () {
        ArmarTablaUsuarios();
    });
    $("#autos").on("click", function () {
        //ArmarTablaAutos();
        ObtenerListadoAutos();
    });
    $("#altaAutos").on("click", function () {
        AltaAuto();
    });
});
function ArmarAlert(mensaje, tipo) {
    if (tipo === void 0) { tipo = "success"; }
    var alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="text-justify text-left">' + mensaje + ' </span></div>';
    return alerta;
}
function ArmarTablaUsuarios() {
    $.ajax({
        type: 'GET',
        url: APIREST,
        dataType: "json",
        data: {},
        headers: {},
        async: true
    })
        .done(function (resultado) {
        var mensaje = 'No hay Usuarios que mostrar!';
        var tipo = 'success';
        if (resultado.exito) {
            var jsonUsuarios = resultado.dato;
            var tablaUsuarios = "\n                                                <h4 style=\"padding-top:2em;\">Lista de Usuarios</h4>\n\n                                                <div class=\"table-responsive\">\n                                                    <table class=\"table\">\n                                                        <tr>\n                                                            <th>CORREO </th>\n                                                            <th>NOMBRE </th>\n                                                            <th>APELLIDO </th>\n                                                            <th>PERFIL </th>\n                                                            <th>FOTO </th>\n                                                        </tr>";
            for (var index = 0; index < jsonUsuarios.length; index++) {
                /* alert(JSON.stringify(jsonUsuarios[index]));        */
                tablaUsuarios += "\n                        <tr>\n                            <td>" + jsonUsuarios[index].correo + "</td>\n                            <td>" + jsonUsuarios[index].nombre + "</td>\n                            <td>" + jsonUsuarios[index].apellido + "</td>\n                            <td>" + jsonUsuarios[index].perfil + "</td>                                                                                            \n                            <td><img src='" + jsonUsuarios[index].foto + "' width='50px' height='50px'/></td>                                      \n                        </tr>";
            }
            tablaUsuarios += "</table></div>";
            /* <td>
                <input type='button' value=Eliminar class=MiBotonUTN id=btnEliminar onclick='DeleteEmployee($aux_Legajo)'>
            </td>
            <td>
                <input type='button' onclick='ModificarEmployee($aux_DNI)' value='Modificar'>
            </td>   */
            $("#divDer").html(tablaUsuarios);
        }
        else {
            mensaje = resultado.mensaje;
            tipo = 'danger';
            var alerta = ArmarAlert(mensaje, tipo);
            $("#divDer").html(alerta);
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function ArmarTablaAutos(listaAutos) {
    var jsonAutos = listaAutos;
    var tablaAutos = "\n                            <h4 style=\"padding-top:2em;\">Lista de Autos</h4>\n\n                            <table class=\"table table-dark table-hover\">\n                                <tr>\n                                    <th>COLOR</th>\n                                    <th>MARCA</th>\n                                    <th>PRECIO</th>\n                                    <th>MODELO</th>\n                                    <th>Modificar</th>\n                                    <th>Eliminar</th>\n                                </tr>";
    for (var index = 0; index < jsonAutos.length; index++) {
        tablaAutos += "\n                        <tr>                               \n                        <td>" + jsonAutos[index].color + "</td>\n                        <td>" + jsonAutos[index].marca + "</td>\n                        <td>" + jsonAutos[index].precio + "</td>\n                        <td>" + jsonAutos[index].modelo + "</td>" +
            "<td><a href='#' class='btn btn-success' data-action='modificar' data-obj_cd='" + JSON.stringify(jsonAutos[index]) + "' title='Modificar'" +
            "  ><i class='bi bi-pencil'></i></a></td>"
            +
                "<td><a href='#' class='btn btn-danger' data-action='eliminar' data-obj_cd='" + JSON.stringify(jsonAutos[index]) + "' title='Eliminar'" +
            " data-toggle='modal' data-target='#ventana_modal_auto' ><i class='bi bi-x-circle'></i></a></td>";
    }
    /**ANDA CON BOTONES MODIFICAR Y ELIMINAR */
    /*  for (let index = 0; index < jsonAutos.length; index++) {
         tablaAutos += `
                 <tr>
                 <td>${jsonAutos[index].color}</td>
                 <td>${jsonAutos[index].marca}</td>
                 <td>${jsonAutos[index].precio}</td>
                 <td>${jsonAutos[index].modelo}</td>`+

                 "<td><a href='#' class='btn btn-success' data-action='modificar' data-obj_cd='"+JSON.stringify(jsonAutos[index])+"' title='Modificar'"+
                 " data-toggle='modal' data-target='#ventana_modal' ><i class='bi bi-pencil'></i></a></td>"
                 +

                 "<td><a href='#' class='btn btn-danger' data-action='eliminar' data-obj_cd='"+JSON.stringify(jsonAutos[index])+"' title='Eliminar'"+
                 " data-toggle='modal' data-target='#ventana_modal_auto' ><i class='bi bi-x-circle'></i></a></td>";
         }   */
    tablaAutos += "</table>";
    //$("#divIzq").html(tablaAutos);
    return tablaAutos;
}
//PRIMERO
function ObtenerListadoAutos() {
    /* $("#divResultado").html(""); */
    $.ajax({
        type: 'GET',
        url: APIREST + "autos",
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        console.log(JSON.stringify(resultado));
        if (resultado.exito) {
            //SEGUNDO -ARMO LA TABLA DE AUTOS 
            var tabla = ArmarTablaAutos(resultado.dato);
            $("#divIzq").html(tabla);
            $('[data-action="modificar"]').on('click', function (e) {
                var obj_auto_string = $(this).attr("data-obj_cd");
                var obj_cd = JSON.parse(obj_auto_string);
                /* let formulario = MostrarFormAutos("modificacion", obj_cd); */
                ModificarAutoALTA(obj_cd);
            });
            /**MODIFICAR Y DELETE JUNTOS */
            /*  $('[data-action="modificar"]').on('click', function (e) {
                 
                 let obj_auto_string:any = $(this).attr("data-obj_cd");
                 let obj_cd = JSON.parse(obj_auto_string);

                 let formulario = MostrarFormAutos("modificacion", obj_cd);
             
                 $("#cuerpo_modal").html(formulario);
             }); */
            $('[data-action="eliminar"]').on('click', function (e) {
                var obj_auto_string = $(this).attr("data-obj_cd");
                var obj_cd = JSON.parse(obj_auto_string);
                var formulario = MostrarFormAutos("baja", obj_cd);
                $("#cuerpo_modal_auto").html(formulario);
            });
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divIzq").html(alerta);
    });
}
function MostrarFormAutos(accion, obj_auto) {
    if (obj_auto === void 0) { obj_auto = null; }
    var funcion = "";
    var encabezado = "";
    var solo_lectura = "";
    switch (accion) {
        case "alta":
            funcion = 'AgregarCD(event)';
            encabezado = 'AGREGAR CD';
            break;
        case "baja":
            funcion = 'EliminarAuto(event)';
            encabezado = 'ELIMINAR AUTO';
            solo_lectura = "readonly";
            break;
        case "modificacion":
            funcion = 'ModificarAuto(event)';
            encabezado = 'MODIFICAR AUTO';
            break;
    }
    var id = "";
    var color = "";
    var marca = "";
    var precio = "";
    var modelo = "";
    if (obj_auto !== null) {
        id = obj_auto.id;
        color = obj_auto.color;
        marca = obj_auto.marca;
        precio = obj_auto.precio;
        modelo = obj_auto.modelo;
    }
    var form = '<h4 style="padding-top:1em;">' + encabezado + '</h4>\
                            <div class="row justify-content-center">\
                                <div class="col-md-8">\
                                    <form class="was-validated">\
                                        <div class="form-group">\
                                            <label for="idAuto">ID:</label>\
                                            <input type="text" class="form-control " id="idAuto" value="' + id + '" readonly >\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="color">Título:</label>\
                                            <input type="text" class="form-control" id="color" placeholder="Ingresar color"\
                                                name="color" value="' + color + '" ' + solo_lectura + ' required>\
                                            <div class="valid-feedback">OK.</div>\
                                            <div class="invalid-feedback">Valor requerido.</div>\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="marca">marca:</label>\
                                            <input type="text" class="form-control" id="marca" placeholder="Ingresar marca" name="marca"\
                                                value="' + marca + '" ' + solo_lectura + ' required>\
                                            <div class="valid-feedback">OK.</div>\
                                            <div class="invalid-feedback">Valor requerido.</div>\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="precio">precio:</label>\
                                            <input type="number" class="form-control" id="precio" placeholder="Ingresar precio" name="precio"\
                                                value="' + precio + '" ' + solo_lectura + ' required>\
                                            <div class="valid-feedback">OK.</div>\
                                            <div class="invalid-feedback">Valor requerido.</div>\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="modelo">modelo:</label>\
                                            <input type="text" class="form-control" id="modelo" placeholder="Ingresar modelo" name="modelo"\
                                                value="' + modelo + '" ' + solo_lectura + ' required>\
                                            <div class="valid-feedback">OK.</div>\
                                            <div class="invalid-feedback">Valor requerido.</div>\
                                        </div>\
                                        <div class="row justify-content-between">\
                                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar">\
                                            <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="' + funcion + '" >Aceptar</button>\
                                        </div>\
                                    </form>\
                                </div>\
                            </div>';
    return form;
}
function EliminarAuto(e) {
    e.preventDefault();
    var id = $("#idAuto").val();
    $.ajax({
        type: 'DELETE',
        url: APIREST + "cars/" + id,
        dataType: "json",
        data: {},
        headers: { "content-type": "application/json" },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        ObtenerListadoAutos();
        /*  $("#cuerpo_modal_auto").html(""); */
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = jqXHR.responseText;
        var alerta = ArmarAlert(retorno, "danger");
        $("#divIzq").html(alerta);
    });
}
function ModificarAuto(e) {
    e.preventDefault();
    var id = $("#idAuto").val();
    var color = $("#color").val();
    var marca = $("#marca").val();
    var precio = $("#precio").val();
    var modelo = $("#modelo").val();
    var dato = {};
    dato.id_auto = id;
    dato.color = color;
    dato.marca = marca;
    dato.precio = precio;
    dato.modelo = modelo;
    var json = JSON.stringify(dato);
    $.ajax({
        type: 'PUT',
        url: APIREST + "cars/" + json,
        dataType: "json",
        data: {},
        headers: { "content-type": "application/json" },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        ObtenerListadoAutos();
        /* $("#cuerpo_modal_cd").html("");       */
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = jqXHR.responseText;
        var alerta = ArmarAlert(retorno, "danger");
        $("#divIzq").html(alerta);
    });
}
function AltaAuto() {
    var form = "\n        <div class=\"container bg-darkcyan\">\n        <div class=\"row justify-content-center mt-5\">\n            <div class=\"col-12 col-lg-4 mt-2 p-4 pt-2 rounded-3 \" style=\"background-color: darkcyan;\">\n                <form action=\"\">\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\" fas fa-trademark pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" class=\"form-control\" placeholder=\"Marca\" id=\"txtMarca\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"fas fa-palette pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Color\" class=\"form-control\" id=\"txtColor\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"fas fa-car pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Modelo\" class=\"form-control\" id=\"txtModelo\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\" fas fa-dollar-sign pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"number\" placeholder=\"Precio\" class=\"form-control\" id=\"txtPrecio\">\n                        </div>\n                    </div>\n                    <div class=\"row content-center\">\n\n                            <div id=\"divResultadoAgregarAuto\" class=\"col-12 col-md-12 container-fluid\">\n                            </div>\n                    </div>\n                    <div class=\"row justify-content-around mt-4\">\n                        <button type=\"submit\" id=\"btnAgregar\" class=\"col-5 btn btn-primary\">Agregar</button>\n                        <button type=\"reset\" class=\"col-5 btn btn-warning text-light\">Limpiar</button>\n                    </div>\n                </form>\n            </div>\n        </div>\n    </div>";
    $("#divIzq").html(form);
    $("#btnAgregar").on("click", function (e) {
        var auto = {};
        var marca = $("#txtMarca").val();
        var color = $("#txtColor").val();
        var modelo = $("#txtModelo").val();
        var precio = $("#txtPrecio").val();
        auto.marca = marca;
        auto.color = color;
        auto.modelo = modelo;
        auto.precio = precio;
        $.ajax({
            type: 'POST',
            url: APIREST,
            dataType: "json",
            data: { "auto": JSON.stringify(auto) },
            async: true
        }).done(function (resultado) {
            var mensaje = 'Usuario válido!';
            var tipo = 'success';
            console.log(resultado.mensaje);
            if (resultado.exito) {
                ObtenerListadoAutos();
            }
            else {
                mensaje = resultado.mensaje;
                tipo = 'danger';
                var alerta = ArmarAlert(mensaje, tipo);
                $("#divIzq").html(alerta);
                e.preventDefault();
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log("error al agregar.");
        });
    });
}
/* #region  Funcion ModificarAuto */
function ModificarAutoALTA(item) {
    var id = item.id;
    var form = "\n                            <div class=\"container bg-darkcyan\">\n                            <div class=\"row justify-content-center mt-5\">\n                                <div class=\"col-12 col-lg-4 mt-2 p-4 pt-2 rounded-3 \" style=\"background-color: darkcyan;\">\n                                    <form action=\"\">\n                                        <div class=\"mb-3\">\n                                            <div class=\"d-flex\">\n                                                <i class=\" fas fa-trademark pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                                                <input type=\"text\" class=\"form-control\" placeholder=\"Marca\" id=\"txtMarca\" value=\"" + item.marca + "\">\n                                            </div>\n                                        </div>\n                                        <div class=\"mb-3\">\n                                            <div class=\"d-flex\">\n                                                <i class=\"fas fa-palette pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                                                <input type=\"text\" placeholder=\"Color\" class=\"form-control\" id=\"txtColor\" value=\"" + item.color + "\">\n                                            </div>\n                                        </div>\n                                        <div class=\"mb-3\">\n                                            <div class=\"d-flex\">\n                                                <i class=\"fas fa-car pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                                                <input type=\"text\" placeholder=\"Modelo\" class=\"form-control\" id=\"txtModelo\" value=\"" + item.modelo + "\">\n                                            </div>\n                                        </div>\n                                        <div class=\"mb-3\">\n                                            <div class=\"d-flex\">\n                                                <i class=\" fas fa-dollar-sign pb-1 px-2 mx-1 pt-2 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                                                <input type=\"number\" placeholder=\"Precio\" class=\"form-control\" id=\"txtPrecio\" value=\"" + item.precio + "\">\n                                            </div>\n                                        </div>\n\n                                        <div class=\"row content-center\">\n                                                    <br>\n                                                    <br>\n                                                <div id=\"divResultado\" class=\"col-12 col-md-12\">\n                                        </div>\n                                        <div class=\"row justify-content-around mt-4\">\n                                            <button type=\"submit\" id=\"btnEnviarModificacion\" class=\"col-5 btn btn-primary\">Modificar</button>\n                                            <button type=\"reset\" class=\"col-5 btn btn-warning text-light\">Limpiar</button>\n                                        </div>\n                                    </form>\n                                </div>\n                            </div>\n                        </div>";
    $("#divIzq").html(form);
    $("#btnEnviarModificacion").on("click", function (e) {
        var auto = {};
        var marca = $("#txtMarca").val();
        var color = $("#txtColor").val();
        var modelo = $("#txtModelo").val();
        var precio = $("#txtPrecio").val();
        auto.id_auto = id;
        auto.color = color;
        auto.marca = marca;
        auto.precio = precio;
        auto.modelo = modelo;
        var json = JSON.stringify(auto);
        $.ajax({
            type: 'PUT',
            url: APIREST + "cars/" + json,
            dataType: "json",
            data: {},
            headers: {},
            async: true
        }).done(function (resultado) {
            var mensaje = 'Usuario válido!';
            var tipo = 'success';
            console.log(resultado.mensaje);
            if (resultado.exito) {
                ObtenerListadoAutos();
                e.preventDefault();
            }
            else {
                e.preventDefault();
                mensaje = resultado.mensaje;
                tipo = 'danger';
                var alerta = ArmarAlert(mensaje, tipo);
                $("#divIzq").html(alerta);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log("error modificar.");
        });
    });
}
//# sourceMappingURL=principal.js.map