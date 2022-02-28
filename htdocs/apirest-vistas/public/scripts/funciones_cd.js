/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var APIREST = "http://api_slim4_vistas/";
function ArmarAlert(mensaje, tipo) {
    if (tipo === void 0) { tipo = "success"; }
    var alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="d-inline-block text-truncate" style="max-width: 450px;">' + mensaje + ' </span></div>';
    return alerta;
}
function ObtenerListadoCDs() {
    $("#divResultado").html("");
    $.ajax({
        type: 'GET',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        if (resultado.exito) {
            var tabla = ArmarTablaCDs(resultado.datos);
            $("#divResultado").html(tabla);
            $('[data-action="modificar"]').on('click', function (e) {
                var obj_cd_string = $(this).attr("data-obj_cd");
                var obj_cd = JSON.parse(obj_cd_string);
                var formulario = MostrarFormCD("modificacion", obj_cd);
                $("#cuerpo_modal_cd").html(formulario);
            });
            $('[data-action="eliminar"]').on('click', function (e) {
                var obj_cd_string = $(this).attr("data-obj_cd");
                var obj_cd = JSON.parse(obj_cd_string);
                var formulario = MostrarFormCD("baja", obj_cd);
                $("#cuerpo_modal_cd").html(formulario);
            });
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function ArmarTablaCDs(cds) {
    var tabla = '<table class="table table-dark table-hover">';
    tabla += '<tr><th>ID</th><th>TITULO</th><th>CANTANTE</th><th>AÑO</th><th style="width:110px">ACCIONES</th></tr>';
    if (cds === false) {
        tabla += '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
    }
    else {
        cds.forEach(function (cd) {
            tabla += "<tr><td>" + cd.id + "</td><td>" + cd.titulo + "</td><td>" + cd.cantante + "</td><td>" + cd.año + "</td><td>" +
                "<a href='#' class='btn btn-success' data-action='modificar' data-obj_cd='" + JSON.stringify(cd) + "' title='Modificar'" +
                " data-toggle='modal' data-target='#ventana_modal_cd' ><i class='bi bi-pencil'></i></a>" +
                "<a href='#' class='btn btn-danger' data-action='eliminar' data-obj_cd='" + JSON.stringify(cd) + "' title='Eliminar'" +
                " data-toggle='modal' data-target='#ventana_modal_cd' ><i class='bi bi-x-circle'></i></a>" +
                "</td></tr>";
        });
    }
    tabla += "</table>";
    return tabla;
}
function BuscarCDPorId() {
    $("#divResultado").html("");
    var id = $("#id_cd").val();
    $.ajax({
        type: 'GET',
        url: APIREST + "cd_bd/" + id,
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        if (resultado.exito) {
            var tabla = ArmarTablaCDs([resultado.datos]);
            $("#divResultado").html(tabla);
        }
        else {
            $("#divResultado").html("No se encotró el CD con ID = " + id);
        }
        $("#id_cd").val("");
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function ArmarAltaCD() {
    $("#divResultado").html("");
    var formulario = MostrarFormCD("alta");
    $("#divResultado").html(formulario);
}
function MostrarFormCD(accion, obj_cd) {
    if (obj_cd === void 0) { obj_cd = null; }
    var funcion = "";
    var encabezado = "";
    var solo_lectura = "";
    switch (accion) {
        case "alta":
            funcion = 'AgregarCD(event)';
            encabezado = 'AGREGAR CD';
            break;
        case "baja":
            funcion = 'EliminarCD(event)';
            encabezado = 'ELIMINAR CD';
            solo_lectura = "readonly";
            break;
        case "modificacion":
            funcion = 'ModificarCD(event)';
            encabezado = 'MODIFICAR CD';
            break;
    }
    var id = "";
    var titulo = "";
    var cantante = "";
    var año = "";
    if (obj_cd !== null) {
        id = obj_cd.id;
        titulo = obj_cd.titulo;
        cantante = obj_cd.cantante;
        año = obj_cd.año;
    }
    var form = '<h4 style="padding-top:1em;">' + encabezado + '</h4>\
                        <div class="row justify-content-center">\
                            <div class="col-md-8">\
                                <form class="was-validated">\
                                    <div class="form-group">\
                                        <label for="idCd">ID:</label>\
                                        <input type="text" class="form-control " id="idCd" value="' + id + '" readonly >\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="titulo">Título:</label>\
                                        <input type="text" class="form-control" id="titulo" placeholder="Ingresar título"\
                                            name="titulo" value="' + titulo + '" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="cantante">Cantante:</label>\
                                        <input type="text" class="form-control" id="cantante" placeholder="Ingresar cantante" name="cantante"\
                                            value="' + cantante + '" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="año">Año:</label>\
                                        <input type="number" class="form-control" id="año" placeholder="Ingresar año" name="año"\
                                            value="' + año + '" ' + solo_lectura + ' required>\
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
function AgregarCD(e) {
    e.preventDefault();
    var titulo = $("#titulo").val();
    var cantante = $("#cantante").val();
    var año = $("#año").val();
    $.ajax({
        type: 'POST',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: { "titulo": titulo, "cantante": cantante, "anio": año },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        var alerta = ArmarAlert(resultado.datos.mensaje + " - ID: " + resultado.datos.id_agregado);
        $("#divResultado").html(alerta);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function ModificarCD(e) {
    e.preventDefault();
    var id = $("#idCd").val();
    var titulo = $("#titulo").val();
    var cantante = $("#cantante").val();
    var año = $("#año").val();
    var dato = {};
    dato.id = id;
    dato.titulo = titulo;
    dato.cantante = cantante;
    dato.anio = año;
    $.ajax({
        type: 'PUT',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: JSON.stringify(dato),
        headers: { "content-type": "application/json" },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        ObtenerListadoCDs();
        $("#cuerpo_modal_cd").html("");
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = jqXHR.responseText;
        var alerta = ArmarAlert(retorno, "danger");
        $("#divResultado").html(alerta);
    });
}
function EliminarCD(e) {
    e.preventDefault();
    var id = $("#idCd").val();
    var dato = {};
    dato.id = id;
    $.ajax({
        type: 'DELETE',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: JSON.stringify(dato),
        headers: { "content-type": "application/json" },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        ObtenerListadoCDs();
        $("#cuerpo_modal_cd").html("");
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = jqXHR.responseText;
        var alerta = ArmarAlert(retorno, "danger");
        $("#divResultado").html(alerta);
    });
}
