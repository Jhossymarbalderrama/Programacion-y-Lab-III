/// <reference path="../node_modules/@types/jquery/index.d.ts" />

    const APIREST: string = "http://scaloneta/";


    /**BOTONES ONCLICK */
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



    /**MENSAJE PARA LOS FAIL */
     function ArmarAlert(mensaje:string, tipo:string = "success"):string
     {
         let alerta:string = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
         alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
         alerta += '<span class="text-justify text-left">' + mensaje + ' </span></div>';
     
         return alerta;
     }



     /**ARMO LA TABLA DE LOS USUARIOS */
    function ArmarTablaUsuarios(): void {
        $.ajax({
            type: 'GET',
            url: APIREST,
            dataType: "json",
            data: {},
            headers: {},
            async: true
        })
        .done(function (resultado: any){
    
            let mensaje:string = 'No hay Usuarios que mostrar!';
            let tipo:string = 'success';
    
            if(resultado.exito){
                
                let jsonUsuarios : any = resultado.dato;

                let tablaUsuarios : string = `
                                                <h4 style="padding-top:2em;">Lista de Usuarios</h4>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th>CORREO </th>
                                                            <th>NOMBRE </th>
                                                            <th>APELLIDO </th>
                                                            <th>PERFIL </th>
                                                            <th>FOTO </th>
                                                        </tr>`;                
                
                for (let index = 0; index < jsonUsuarios.length; index++) {
                    /* alert(JSON.stringify(jsonUsuarios[index]));        */
                    tablaUsuarios += `
                        <tr>
                            <td>${jsonUsuarios[index].correo}</td>
                            <td>${jsonUsuarios[index].nombre}</td>
                            <td>${jsonUsuarios[index].apellido}</td>
                            <td>${jsonUsuarios[index].perfil}</td>                                                                                            
                            <td><img src='${jsonUsuarios[index].foto}' width='50px' height='50px'/></td>                                      
                        </tr>`;                         
                        }       
                tablaUsuarios += `</table></div>`;
                
                /* <td>
                    <input type='button' value=Eliminar class=MiBotonUTN id=btnEliminar onclick='DeleteEmployee($aux_Legajo)'>
                </td>                                        
                <td>
                    <input type='button' onclick='ModificarEmployee($aux_DNI)' value='Modificar'>
                </td>   */       
                
                
                $("#divDer").html(tablaUsuarios);
            }else{
                mensaje = resultado.mensaje;
                tipo = 'danger';
                let alerta:string = ArmarAlert(mensaje, tipo);
                $("#divDer").html(alerta);
            }
        }).fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
    
            let retorno = JSON.parse(jqXHR.responseText);
    
            let alerta:string = ArmarAlert(retorno.mensaje, "danger");
    
            $("#divResultado").html(alerta);
        });
    }


    /**ARMO TABLA DE LOS AUTOS */
    function ArmarTablaAutos(listaAutos:any): string {


        let jsonAutos : any = listaAutos;

        let tablaAutos : string = `
                            <h4 style="padding-top:2em;">Lista de Autos</h4>

                            <table class="table table-dark table-hover">
                                <tr>
                                    <th>COLOR</th>
                                    <th>MARCA</th>
                                    <th>PRECIO</th>
                                    <th>MODELO</th>
                                    <th>Modificar</th>
                                    <th>Eliminar</th>
                                </tr>`;               

                for (let index = 0; index < jsonAutos.length; index++) {
                tablaAutos += `
                        <tr>                               
                        <td>${jsonAutos[index].color}</td>
                        <td>${jsonAutos[index].marca}</td>
                        <td>${jsonAutos[index].precio}</td>
                        <td>${jsonAutos[index].modelo}</td>`+   

                        "<td><a href='#' class='btn btn-success' data-action='modificar' data-obj_cd='"+JSON.stringify(jsonAutos[index])+"' title='Modificar'"+
                        "  ><i class='bi bi-pencil'></i></a></td>"
                        + 

                        "<td><a href='#' class='btn btn-danger' data-action='eliminar' data-obj_cd='"+JSON.stringify(jsonAutos[index])+"' title='Eliminar'"+
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
                                
                tablaAutos += `</table>`;
        //$("#divIzq").html(tablaAutos);
           
        return tablaAutos;
    }


    /**OBTENGO LA LISTA DE AUTOS */
    //PRIMERO
    function ObtenerListadoAutos():void 
    {    
        /* $("#divResultado").html(""); */

        $.ajax({
            type: 'GET',
            url: APIREST + "autos",
            dataType: "json",
            data: {},
            async: true
        })
        .done(function (resultado:any) {

            console.log(JSON.stringify(resultado));        

            if(resultado.exito){

                //SEGUNDO -ARMO LA TABLA DE AUTOS 
                let tabla = ArmarTablaAutos(resultado.dato);

                $("#divIzq").html(tabla);

                $('[data-action="modificar"]').on('click', function (e) {
                    
                    let obj_auto_string:any = $(this).attr("data-obj_cd");
                    let obj_cd = JSON.parse(obj_auto_string);

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

                    let obj_auto_string : any= $(this).attr("data-obj_cd");
                    let obj_cd = JSON.parse(obj_auto_string);

                    let formulario = MostrarFormAutos("baja", obj_cd);
                
                    $("#cuerpo_modal_auto").html(formulario);
                }); 
            }       
        
        })
        .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
            
            let retorno = JSON.parse(jqXHR.responseText);

            let alerta:string = ArmarAlert(retorno.mensaje, "danger");

            $("#divIzq").html(alerta);
        });    
    }



    /** */
    function MostrarFormAutos(accion:string, obj_auto:any=null):string 
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
                funcion = 'EliminarAuto(event)';
                encabezado = 'ELIMINAR AUTO';
                solo_lectura = "readonly";
                break;
        
            case "modificacion":
                funcion = 'ModificarAuto(event)';
                encabezado = 'MODIFICAR AUTO';
                break;
        }

        let id = "";
        let color = "";
        let marca = "";
        let precio = "";
        let modelo = "";

        if (obj_auto !== null) 
        {
            id = obj_auto.id;
            color = obj_auto.color;
            marca = obj_auto.marca;
            precio = obj_auto.precio; 
            modelo = obj_auto.modelo;  
        }

        let form:string = '<h4 style="padding-top:1em;">'+encabezado+'</h4>\
                            <div class="row justify-content-center">\
                                <div class="col-md-8">\
                                    <form class="was-validated">\
                                        <div class="form-group">\
                                            <label for="idAuto">ID:</label>\
                                            <input type="text" class="form-control " id="idAuto" value="'+id+'" readonly >\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="color">Título:</label>\
                                            <input type="text" class="form-control" id="color" placeholder="Ingresar color"\
                                                name="color" value="'+color+'" '+solo_lectura+' required>\
                                            <div class="valid-feedback">OK.</div>\
                                            <div class="invalid-feedback">Valor requerido.</div>\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="marca">marca:</label>\
                                            <input type="text" class="form-control" id="marca" placeholder="Ingresar marca" name="marca"\
                                                value="'+marca+'" '+solo_lectura+' required>\
                                            <div class="valid-feedback">OK.</div>\
                                            <div class="invalid-feedback">Valor requerido.</div>\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="precio">precio:</label>\
                                            <input type="number" class="form-control" id="precio" placeholder="Ingresar precio" name="precio"\
                                                value="'+precio+'" '+solo_lectura+' required>\
                                            <div class="valid-feedback">OK.</div>\
                                            <div class="invalid-feedback">Valor requerido.</div>\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="modelo">modelo:</label>\
                                            <input type="text" class="form-control" id="modelo" placeholder="Ingresar modelo" name="modelo"\
                                                value="'+modelo+'" '+solo_lectura+' required>\
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



    function EliminarAuto(e:Event):void 
    {
        e.preventDefault();

        let id = $("#idAuto").val();

        $.ajax({
            type: 'DELETE',
            url: APIREST + "cars/"+id,
            dataType: "json",
            data: {},
            headers : {"content-type":"application/json"},
            async: true
        })
        .done(function (resultado:any) {

            console.log(resultado);

            ObtenerListadoAutos();
            
           /*  $("#cuerpo_modal_auto").html(""); */
        })
        .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

            let retorno = jqXHR.responseText;

            let alerta:string = ArmarAlert(retorno, "danger");

            $("#divIzq").html(alerta);
        });    
    } 


    function ModificarAuto(e:Event):void 
    {  
        e.preventDefault();

        let id = $("#idAuto").val();
        let color = $("#color").val();
        let marca = $("#marca").val();
        let precio = $("#precio").val();
        let modelo = $("#modelo").val();

        let dato : any = {};
        dato.id_auto = id;
        dato.color = color;
        dato.marca = marca;
        dato.precio = precio;
        dato.modelo = modelo;

        let json : any = JSON.stringify(dato);
        
        $.ajax({
            type: 'PUT',
            url: APIREST + "cars/"+json,
            dataType: "json",
            data: {},
            headers : {"content-type":"application/json"},
            async: true
        })
        .done(function (resultado:any) {

            console.log(resultado);

            ObtenerListadoAutos();

            /* $("#cuerpo_modal_cd").html("");       */
        })
        .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

            let retorno = jqXHR.responseText;

            let alerta:string = ArmarAlert(retorno, "danger");

            $("#divIzq").html(alerta);

        });               
    }


    /**ALTA DE AUTOS HTML */
    function AltaAuto(): void {        
        let form: string = `
        <div class="container bg-darkcyan">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-4 mt-2 p-4 pt-2 rounded-3 " style="background-color: darkcyan;">
                <form action="">
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-trademark pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" class="form-control" placeholder="Marca" id="txtMarca">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="fas fa-palette pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Color" class="form-control" id="txtColor">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="fas fa-car pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Modelo" class="form-control" id="txtModelo">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-dollar-sign pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="number" placeholder="Precio" class="form-control" id="txtPrecio">
                        </div>
                    </div>
                    <div class="row content-center">

                            <div id="divResultadoAgregarAuto" class="col-12 col-md-12 container-fluid">
                            </div>
                    </div>
                    <div class="row justify-content-around mt-4">
                        <button type="submit" id="btnAgregar" class="col-5 btn btn-primary">Agregar</button>
                        <button type="reset" class="col-5 btn btn-warning text-light">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;
    
        $("#divIzq").html(form);
    
    
        $("#btnAgregar").on("click", function (e) {
    
            let auto: any = {};
            let marca = $("#txtMarca").val();
            let color = $("#txtColor").val();
            let modelo = $("#txtModelo").val();
            let precio = $("#txtPrecio").val();
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
            }).done(function (resultado: any) {
                let mensaje: string = 'Usuario válido!';
                let tipo: string = 'success';
                console.log(resultado.mensaje);
                if (resultado.exito) {
                    ObtenerListadoAutos();
                }
                else {
                    
                    mensaje = resultado.mensaje;
                    tipo = 'danger';
                    let alerta: string = ArmarAlert(mensaje, tipo);
                    $("#divIzq").html(alerta);
                    e.preventDefault();
                }
            }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                console.log("error al agregar.");
            });
        });
    }

    
    /* #region  Funcion ModificarAuto */
    function ModificarAutoALTA(item: any): void {
        let id = item.id;

        let form: string = `
                            <div class="container bg-darkcyan">
                            <div class="row justify-content-center mt-5">
                                <div class="col-12 col-lg-4 mt-2 p-4 pt-2 rounded-3 " style="background-color: darkcyan;">
                                    <form action="">
                                        <div class="mb-3">
                                            <div class="d-flex">
                                                <i class=" fas fa-trademark pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                                                <input type="text" class="form-control" placeholder="Marca" id="txtMarca" value="${item.marca}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex">
                                                <i class="fas fa-palette pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                                                <input type="text" placeholder="Color" class="form-control" id="txtColor" value="${item.color}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex">
                                                <i class="fas fa-car pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                                                <input type="text" placeholder="Modelo" class="form-control" id="txtModelo" value="${item.modelo}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex">
                                                <i class=" fas fa-dollar-sign pb-1 px-2 mx-1 pt-2 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                                                <input type="number" placeholder="Precio" class="form-control" id="txtPrecio" value="${item.precio}">
                                            </div>
                                        </div>

                                        <div class="row content-center">
                                                    <br>
                                                    <br>
                                                <div id="divResultado" class="col-12 col-md-12">
                                        </div>
                                        <div class="row justify-content-around mt-4">
                                            <button type="submit" id="btnEnviarModificacion" class="col-5 btn btn-primary">Modificar</button>
                                            <button type="reset" class="col-5 btn btn-warning text-light">Limpiar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>`;

    
        $("#divIzq").html(form);
    
    
        $("#btnEnviarModificacion").on("click", function (e) {
    
            let auto: any = {};
            let marca = $("#txtMarca").val();
            let color = $("#txtColor").val();
            let modelo = $("#txtModelo").val();
            let precio = $("#txtPrecio").val();
            auto.id_auto = id;
            auto.color = color;
            auto.marca = marca;
            auto.precio = precio;
            auto.modelo = modelo;
            

            let json : any = JSON.stringify(auto);
    
            $.ajax({
                type: 'PUT',
                url: APIREST+"cars/"+json,
                dataType: "json",
                data: {},
                headers: {},
                async: true
            }).done(function (resultado: any) {
                let mensaje: string = 'Usuario válido!';
                let tipo: string = 'success';
    
                console.log(resultado.mensaje);
                
                if (resultado.exito) {
                    ObtenerListadoAutos();
                    e.preventDefault();
                }
                else {
                    e.preventDefault();
                    mensaje = resultado.mensaje;
                    tipo = 'danger';
                    let alerta: string = ArmarAlert(mensaje, tipo);
                    $("#divIzq").html(alerta);
                }
            }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                console.log("error modificar.");
            });
        });
    }