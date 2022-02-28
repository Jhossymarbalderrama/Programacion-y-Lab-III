/// <reference path="../node_modules/@types/jquery/index.d.ts" />

const APIREST:string = "http://api_slim4_vistas/";

function ArmarAlert(mensaje:string, tipo:string = "success"):string
{
    let alerta:string = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="d-inline-block text-truncate" style="max-width: 450px;">' + mensaje + ' </span></div>';

    return alerta;
}

function ObtenerListadoCDs():void 
{    
    $("#divResultado").html("");

    $.ajax({
        type: 'GET',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);

        if(resultado.exito){

            let tabla = ArmarTablaCDs(resultado.datos);

            $("#divResultado").html(tabla);

            $('[data-action="modificar"]').on('click', function (e) {
                
                let obj_cd_string = $(this).attr("data-obj_cd");
                let obj_cd = JSON.parse(obj_cd_string);

                let formulario = MostrarFormCD("modificacion", obj_cd);
            
                $("#cuerpo_modal_cd").html(formulario);           
            });
    
            $('[data-action="eliminar"]').on('click', function (e) {

                let obj_cd_string = $(this).attr("data-obj_cd");
                let obj_cd = JSON.parse(obj_cd_string);

                let formulario = MostrarFormCD("baja", obj_cd);
            
                $("#cuerpo_modal_cd").html(formulario);
            });
        }       
       
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        
        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta);
    });    
}

function ArmarTablaCDs(cds):string 
{   
    let tabla:string = '<table class="table table-dark table-hover">';
    tabla += '<tr><th>ID</th><th>TITULO</th><th>CANTANTE</th><th>AÑO</th><th style="width:110px">ACCIONES</th></tr>';

    if(cds === false)
    {
        tabla += '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
    }
    else
    {
        cds.forEach(cd => {

            tabla += "<tr><td>"+cd.id+"</td><td>"+cd.titulo+"</td><td>"+cd.cantante+"</td><td>"+cd.año+"</td><td>"+
            "<a href='#' class='btn btn-success' data-action='modificar' data-obj_cd='"+JSON.stringify(cd)+"' title='Modificar'"+
            " data-toggle='modal' data-target='#ventana_modal_cd' ><i class='bi bi-pencil'></i></a>"+
            "<a href='#' class='btn btn-danger' data-action='eliminar' data-obj_cd='"+JSON.stringify(cd)+"' title='Eliminar'"+
            " data-toggle='modal' data-target='#ventana_modal_cd' ><i class='bi bi-x-circle'></i></a>"+
            "</td></tr>";
        });
    }

    tabla += "</table>";

    return tabla;
}

function BuscarCDPorId():void 
{
    $("#divResultado").html("");

    let id = $("#id_cd").val();

    $.ajax({
        type: 'GET',
        url: APIREST + "cd_bd/" + id,
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);

        if(resultado.exito){

            let tabla = ArmarTablaCDs([resultado.datos]);

            $("#divResultado").html(tabla);
        }
        else {

            $("#divResultado").html("No se encotró el CD con ID = " + id);
        }
       
        $("#id_cd").val("");

    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        
        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta);
    });    
}

function ArmarAltaCD()
{
    $("#divResultado").html("");

    let formulario = MostrarFormCD("alta");

    $("#divResultado").html(formulario);
}

function MostrarFormCD(accion:string, obj_cd:any=null):string 
{
    let funcion = "";
    let encabezado = "";
    let solo_lectura = "";

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

    let id = "";
    let titulo = "";
    let cantante = "";
    let año = "";

    if (obj_cd !== null) 
    {
        id = obj_cd.id;
        titulo = obj_cd.titulo;
        cantante = obj_cd.cantante;
        año = obj_cd.año;       
    }

    let form:string = '<h4 style="padding-top:1em;">'+encabezado+'</h4>\
                        <div class="row justify-content-center">\
                            <div class="col-md-8">\
                                <form class="was-validated">\
                                    <div class="form-group">\
                                        <label for="idCd">ID:</label>\
                                        <input type="text" class="form-control " id="idCd" value="'+id+'" readonly >\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="titulo">Título:</label>\
                                        <input type="text" class="form-control" id="titulo" placeholder="Ingresar título"\
                                            name="titulo" value="'+titulo+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="cantante">Cantante:</label>\
                                        <input type="text" class="form-control" id="cantante" placeholder="Ingresar cantante" name="cantante"\
                                            value="'+cantante+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="año">Año:</label>\
                                        <input type="number" class="form-control" id="año" placeholder="Ingresar año" name="año"\
                                            value="'+año+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="row justify-content-between">\
                                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar">\
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="'+funcion+'" >Aceptar</button>\
                                    </div>\
                                </form>\
                            </div>\
                        </div>';

    return form;
}

function AgregarCD(e:Event):void 
{  
    e.preventDefault();

    let titulo = $("#titulo").val();
    let cantante = $("#cantante").val();
    let año = $("#año").val();

    $.ajax({
        type: 'POST',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: {"titulo":titulo, "cantante":cantante, "anio":año},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);

        let alerta:string = ArmarAlert(resultado.datos.mensaje + " - ID: " + resultado.datos.id_agregado);

        $("#divResultado").html(alerta);
        
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta);

    });    
}

function ModificarCD(e:Event):void 
{  
    e.preventDefault();

    let id = $("#idCd").val();
    let titulo = $("#titulo").val();
    let cantante = $("#cantante").val();
    let año = $("#año").val();

    let dato : any = {};
    dato.id = id;
    dato.titulo = titulo;
    dato.cantante = cantante;
    dato.anio = año;

    $.ajax({
        type: 'PUT',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: JSON.stringify(dato),
        headers : {"content-type":"application/json"},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);

        ObtenerListadoCDs();

        $("#cuerpo_modal_cd").html("");      
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = jqXHR.responseText;

        let alerta:string = ArmarAlert(retorno, "danger");

        $("#divResultado").html(alerta);

    });    
}

function EliminarCD(e:Event):void 
{
    e.preventDefault();

    let id = $("#idCd").val();

    let dato : any = {};
    dato.id = id;

    $.ajax({
        type: 'DELETE',
        url: APIREST + "cd_bd/",
        dataType: "json",
        data: JSON.stringify(dato),
        headers : {"content-type":"application/json"},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);

        ObtenerListadoCDs();
        
        $("#cuerpo_modal_cd").html("");
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = jqXHR.responseText;

        let alerta:string = ArmarAlert(retorno, "danger");

        $("#divResultado").html(alerta);
    });    
}