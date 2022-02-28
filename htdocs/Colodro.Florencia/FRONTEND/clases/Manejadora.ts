///<reference path="./ajax.ts"/>

namespace PrimerParcial
{
    interface IParte2{
        EliminarProducto(objJSON: string):void;
        ModificarProducto():void;
    }
    interface IParte3{
        VerificarProductoEnvasado():void;
        AgregarProductoFoto():void;
        BorrarProductoFoto():void;
        ModificarProductoFoto():void;
    }

    export class Manejadora implements IParte2, IParte3
    {
        EliminarProducto(objJSON: string): void {
            throw new Error("Method not implemented.");
        }
        VerificarProductoEnvasado(): void {
            Manejadora.VerificarProductoEnvasado();
        }
        AgregarProductoFoto(): void {
            Manejadora.AgregarProductoFoto();
        }
        BorrarProductoFoto(): void {
            throw new Error("Method not implemented.");
        }
        ModificarProductoFoto(): void {
            throw new Error("Method not implemented.");
        }













        //PARTE 3

        //Mostrar para la parte 3
        static MostrarProductosEnvasadosFoto()
        {
            let ajax : Ajax = new Ajax();
            let params= `tabla=json`;
            ajax.Get('../BACKEND/ListadoProductosEnvasados.php',Manejadora.successMostrarProductosEnvasadosFoto,params,Manejadora.Fail); 
        }


        static successMostrarProductosEnvasadosFoto(retorno : string)
        {
            let oDecodificado : Entidades.ProductoEnvasado [] = JSON.parse(retorno);
            let tabla = "<table><tr><th>ID</th><th>Nombre</th><th>CodigoBarra</th><th>Origen</th><th>Precio</th><th>Foto</th><th>Acciones</th></tr>";
            oDecodificado.forEach( element  => {
                tabla+= `<tr> <td>${element.id}</td>
                <td>${element.nombre}</td>
                <td>${element.origen}</td>
                <td>${element.codigoBarra}</td>
                <td>${element.precio}</td>`;
                if(element.pathFoto!= null)
                {
                    tabla +=`<td><img src="../BACKEND/productos/imagenes/${element.pathFoto}" width='50px' height='50px'></td>`;
                }else{
                    tabla += "<td>No tiene foto</td>"
                }
                let auxProducto = JSON.stringify(element);
                tabla += `<td> <input type="button" value="eliminar" onclick=PrimerParcial.Manejadora.BorrarProductoFoto('${auxProducto}')></td>`;
                tabla += `<td> <input type="button" value="modificar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.ModificarProductoFotoBoton('${auxProducto}')></td>`;
            });
            tabla+='</tr></table>';
            (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = tabla;
        }
        static VerificarProductoEnvasado()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            let origen:string=(<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let ajax = new Ajax();
            let form : FormData = new FormData();
            let params : string =`{"nombre":"${nombre}","origen":"${origen}"}`;

            form.append('obj_producto',params);
            ajax.Post('../BACKEND/VerificarProductoEnvasado.php',Manejadora.succesVerificarProductoEnvasado,form,Manejadora.Fail);

        }

        static succesVerificarProductoEnvasado(retorno: string)
        {
            (<HTMLInputElement>document.getElementById("divInfo")).innerHTML = retorno;
        }


        static AgregarProductoFoto()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            let origen:string=(<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let precio:string=(<HTMLInputElement> document.getElementById("precio")).value;
            let foto:any=(<HTMLInputElement> document.getElementById("foto")).files;
            let codigoBarra:string=(<HTMLInputElement> document.getElementById("codigoBarra")).value;
            let ajax = new Ajax();
            let form : FormData = new FormData();
            form.append('nombre',nombre);
            form.append('origen',origen);
            form.append('precio',precio);
            form.append('foto',foto[0]);
            form.append('codigoBarra',codigoBarra);
            ajax.Post('../BACKEND/AgregarProductoEnvasado.php',Manejadora.succesAgregarProductoFoto,form,Manejadora.Fail);
        }

        static succesAgregarProductoFoto(retorno: string)
        {
            console.log(retorno);
            alert(retorno);
            Manejadora.MostrarProductosEnvasadosFoto();
        }



        // BorrarProductoFoto. Recibe como parámetro al objeto JSON que se ha de eliminar. Pedir confirmación,
        // mostrando nombre y código de barra, antes de eliminar.
        // Si se confirma se invocará (por AJAX) a “./BACKEND/BorrarProductoEnvasado.php” que recibe el parámetro
        // producto_json (id, codigoBarra, nombre, origen, precio y pathFoto en formato de cadena JSON) por POST. Se deberá borrar el
        // producto envasado (invocando al método Eliminar).
        // Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert lo acontecido. Refrescar el listado para visualizar los cambios.

        static BorrarProductoFoto (objJSON : string)
        {
            let objDecoEliminar : Entidades.ProductoEnvasado =  JSON.parse(objJSON);           
            let respuesta = window.confirm(`Esta seguro de eliminar el producto NOMBRE: ${objDecoEliminar.nombre} CODIGOBARRA: ${objDecoEliminar.codigoBarra}?`);
            //let params = "producto_json="+ objJSON;

            let form : FormData = new FormData();
            let params : string = `{"id":"${objDecoEliminar.id}","nombre":"${objDecoEliminar.nombre}","origen":"${objDecoEliminar.origen}","codigoBarra":"${objDecoEliminar.codigoBarra}","precio":"${objDecoEliminar.precio}","foto":"${objDecoEliminar.pathFoto}"}`;

            form.append('producto_json',params);
            if(respuesta==true)
            {
                let ajax = new Ajax();
                ajax.Post("../BACKEND/BorrarProductoEnvasado.php",Manejadora.succesBorrarProductoFoto,form,Manejadora.Fail);  
            }
        }

        static succesBorrarProductoFoto(retorno: string)
        {
            console.log(retorno);
            alert(retorno);
            Manejadora.MostrarProductosEnvasadosFoto();
        }

        //Modificar 
//         ModificarProductoFoto. Mostrará todos los datos del producto que recibe por parámetro (objeto JSON), en el
// formulario, de tener foto, incluirla en “imgFoto”. Permitirá modificar cualquier campo (incluyendo la foto), a
// excepción del id.
// Al pulsar el botón Modificar (de la página) se invocará (por AJAX) a
// “./BACKEND/ModificarProductoEnvadadoFoto.php” dónde se recibirán por POST los siguientes valores: producto_json

        static ModificarProductoFotoBoton(json : string)
        {
           let producto : Entidades.ProductoEnvasado = JSON.parse(json);
           if(producto.pathFoto != null){
            let foto : string = "../BACKEND/productos/imagenes/"+producto.pathFoto.toString();
            (<HTMLImageElement>document.getElementById("imgFoto")).src = foto;
           }else{
            (<HTMLImageElement>document.getElementById("imgFoto")).src = "../producto_default.jpg";
           }
        
           (<HTMLInputElement> document.getElementById("idProducto")).value = producto.id.toString();
           (<HTMLInputElement> document.getElementById("nombre")).value = producto.nombre;
           (<HTMLInputElement> document.getElementById("codigoBarra")).value = producto.codigoBarra.toString();
           (<HTMLInputElement> document.getElementById("precio")).value = producto.precio.toString();
           (<HTMLInputElement> document.getElementById("cboOrigen")).value = producto.origen;

        }

      
        public static ModificarProductoFoto()
        {
            alert("Estoy en modificar con foto");

            let id: number = parseInt((<HTMLInputElement> document.getElementById("idProducto")).value);
            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let codigoBarra : number = parseInt((<HTMLInputElement> document.getElementById("codigoBarra")).value);
            let precio : number= parseInt((<HTMLInputElement> document.getElementById("precio")).value);
            let origen : string  = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let foto : any =  (<HTMLInputElement> document.getElementById("foto")).files;

            let ajax = new Ajax();
            let params : string = `{"id":${id},"nombre":"${nombre}","origen":"${origen}","codigoBarra":${codigoBarra},"precio":${precio}}`;

            let form :FormData = new FormData();

            form.append('producto_json',params);
            form.append('foto',foto[0]);
            ajax.Post('../BACKEND/ModificarProductoEnvadadoFoto.php',Manejadora.successModificarProductoFoto,form,Manejadora.Fail);
        }

        public static successModificarProductoFoto(cadena : string): void 
        {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(cadena);
            alert(cadena);  
        }




        //PARTE 2
        //SIN INTERFAZ
        static EliminarProductoBoton(objJSON :string): void
        {
            
            //let auxObj : any = JSON.stringify(objJSON);
            let objDecoEliminar : Entidades.ProductoEnvasado =  JSON.parse(objJSON);
            
            let respuesta = window.confirm(`Esta seguro de eliminar el producto: ${objDecoEliminar.nombre} origen:${objDecoEliminar.origen}?`);
            let params = "producto_json="+ objJSON;
            if(respuesta==true)
            {
                let ajax = new Ajax();
                ajax.Post("../BACKEND/EliminarProductoEnvasado.php",Manejadora.succesEliminarProducto,params,Manejadora.Fail);  
            }
        }


        static succesEliminarProducto(retorno: string)
        {
            let oDecodificado = JSON.parse(retorno);
            console.log(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            alert(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            Manejadora.MostrarProductosJSON();
        }



        // ModificarProducto. Mostrará todos los datos del producto que recibe por parámetro (objeto JSON), en el
        // formulario, de tener foto, incluirla en “imgFoto”. Permitirá modificar cualquier campo, a excepción del id.
        // Al pulsar el botón Modificar sin foto (de la página) se invocará (por AJAX) a
        // “./BACKEND/ModificarProductoEnvadado.php” Se recibirán por POST los siguientes valores: producto_json (id,
        // codigoBarra, nombre, origen y precio, en formato de cadena JSON) para modificar un producto envasado en la base de datos.
        // Invocar al método Modificar.
        // Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del producto envasado
        // a ser modificado.
        // Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Refrescar el listado solo si se pudo modificar, caso contrario, informar (por alert y consola) de lo acontecido.
        // NOTA: Agregar una columna extra (Acciones) al listado de productos envasados que permita: Eliminar y
        // Modificar al producto elegido. Para ello, agregue dos botones (input [type=button]) que invoquen a las
        // funciones EliminarProducto y ModificarProducto, respectivamente.

        ModificarProducto(): void {
            throw new Error("Method not implemented.");
        }

        //Interfaz trucha xd
        // EliminarProducto(objJSON : string): void 
        // {
        //     Manejadora.EliminarProductoBoton(objJSON);
        // }

        static ModificarProducto(): void 
        { 
            let id = (<HTMLInputElement> document.getElementById("idProducto")).value;
            let nombre = (<HTMLInputElement> document.getElementById("nombre")).value;
            let codigoBarra = (<HTMLInputElement> document.getElementById("codigoBarra")).value ;
            let precio= (<HTMLInputElement> document.getElementById("precio")).value;
            let origen = (<HTMLInputElement> document.getElementById("cboOrigen")).value;

            let ajax = new Ajax();
            let params : string = `{"id":${id},"nombre":"${nombre}","origen":"${origen}","codigoBarra":${codigoBarra},"precio":${precio}}`;
            let form :FormData = new FormData();
            form.append('producto_json',params);
            ajax.Post('../BACKEND/ModificarProductoEnvadado.php',Manejadora.succesModificar,form,Manejadora.Fail);
            
        }


        static ModificarProductoBoton(json:string): void
        {
           let producto : Entidades.ProductoEnvasado = JSON.parse(json);

           (<HTMLInputElement> document.getElementById("idProducto")).value = producto.id.toString();
           (<HTMLInputElement> document.getElementById("nombre")).value = producto.nombre;
           (<HTMLInputElement> document.getElementById("codigoBarra")).value = producto.codigoBarra.toString();
           (<HTMLInputElement> document.getElementById("precio")).value = producto.precio.toString();
           (<HTMLInputElement> document.getElementById("cboOrigen")).value = producto.origen.toString(); 
        }

        static succesModificar(retorno: string)
        {
            let oDecodificado = JSON.parse(retorno);
            console.log(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            alert(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            //Manejadora.MostrarProductosJSON();
            Manejadora.MostrarProductosEnvasados();

        }

        //         AgregarProductoJSON. Obtiene el nombre y el origen desde la página producto.html y se enviará (por AJAX)
        // hacia “./BACKEND/AltaProductoJSON.php” que invoca al método GuardarJSON pasándole
        // './BACKEND/archivos/productos.json' cómo parámetro para que agregue al producto en el archivo. Retornará un JSON que
        // contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert el mensaje recibido.
   
        static AgregarProductoJSON()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            console.log(nombre);
            let origen:string=(<HTMLInputElement> document.getElementById("cboOrigen")).value;

            let paramsForm=new FormData();
            paramsForm.append("nombre",nombre);
            paramsForm.append("origen",origen);


            let ajax : Ajax = new Ajax();
            ajax.Post("../BACKEND/AltaProductoJSON.php",Manejadora.successAgregarProductoJSON,paramsForm,Manejadora.Fail);  
            
            // ajax.Post("../../BACKEND/AltaProductoJSON.php",Manejadora.successAgregar,paramsForm,Manejadora.Fail);  
           
        }

        
        static MostrarProductosJSON()
        {
            let ajax : Ajax = new Ajax();
            ajax.Get('../BACKEND/ListadoProductosJSON.php',this.successMostrarProductosJSON,'',Manejadora.Fail);
        }

      

        static VerificarProductoJSON()
        {
            let ajax : Ajax = new Ajax();
            let nombre:string=(<HTMLInputElement>document.getElementById("nombre")).value;
            let origen:string=(<HTMLInputElement>document.getElementById("cboOrigen")).value;
            let paramsForm=new FormData();
            paramsForm.append('nombre',nombre);
            paramsForm.append('origen',origen);

            ajax.Post('../BACKEND/VerificarProductoJSON.php',Manejadora.successVerificarProductoJSON,paramsForm,Manejadora.Fail);    
        }

        static MostrarInfoCookie()
        {
            let ajax : Ajax = new Ajax();
            let nombre:string=(<HTMLInputElement>document.getElementById("nombre")).value;
            let origen:string=(<HTMLInputElement>document.getElementById("cboOrigen")).value;
            let params = `nombre=${nombre}&origen=${origen}`;
                         
            ajax.Get('../BACKEND/MostrarCookie.php',Manejadora.successMostrarCookie,params,Manejadora.Fail);    
        }

        

//         Obtiene el código de barra, el nombre, el origen y el precio desde la página
// producto.html, y se enviará (por AJAX) hacia “./BACKEND/AgregarProductoSinFoto.php” que recibe por POST el
// parámetro producto_json (codigoBarra, nombre, origen y precio), en formato de cadena JSON. Se invocará al método Agregar.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
// Informar por consola y alert el mensaje recibido.
        static AgregarProductoSinFoto()
        {
            let ajax : Ajax = new Ajax();
            let nombreI:string=(<HTMLInputElement>document.getElementById("nombre")).value;
            let origenI:string=(<HTMLInputElement>document.getElementById("cboOrigen")).value;
            let codigoBarraI:string=(<HTMLInputElement>document.getElementById("codigoBarra")).value;
            let precioI:string=(<HTMLInputElement>document.getElementById("precio")).value;
      
            let objeto = {codigoBarra:codigoBarraI, nombre : nombreI, origen:origenI,precio:precioI};
            let params = "producto_json"+ `=${JSON.stringify(objeto)}`;
            ajax.Post('../BACKEND/AgregarProductoSinFoto.php',Manejadora.successAgregarProductoSinFoto,params,Manejadora.Fail);  
        }


        static MostrarProductosEnvasados()
        {
            let ajax : Ajax = new Ajax();
            let params= `tabla=json`;

            ajax.Get('../BACKEND/ListadoProductosEnvasados.php',Manejadora.successMostrarProductosEnvasados,params,Manejadora.Fail); 
        }


        static successMostrarProductosEnvasados(retorno : string)
        {
            let oDecodificado : Entidades.ProductoEnvasado [] = JSON.parse(retorno);
            let tabla = "<table><tr><th>ID</th><th>Nombre</th><th>CodigoBarra</th><th>Origen</th><th>Precio</th><th>Foto</th><th>Acciones</th></tr>";
            oDecodificado.forEach( element  => {
                tabla+= `<tr> <td>${element.id}</td>
                <td>${element.nombre}</td>
                <td>${element.origen}</td>
                <td>${element.codigoBarra}</td>
                <td>${element.precio}</td>`;
                if(element.pathFoto!= null)
                {
                    tabla +=`<td><img src="../BACKEND/productos/imagenes/${element.pathFoto}" width='50px' height='50px'></td>`;
                }else{
                    tabla += "<td>No tiene foto</td>"
                }
                let auxProducto = JSON.stringify(element);
                // tabla += `<td> <input type="button" value="eliminar" onclick=PrimerParcial.Manejadora.EliminarProductoBoton('${auxProducto}')></td>`; Este funciona,sin Interz
                tabla += `<td> <input type="button" value="eliminar" onclick=PrimerParcial.Manejadora.EliminarProductoBoton('${auxProducto}')></td>`;
                tabla += `<td> <input type="button" value="modificar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.ModificarProductoBoton('${auxProducto}')></td>`;
            });
            tabla+='</tr></table>';
            (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = tabla;
        }

       
        //SUCCESS (Manejadora.)
        static successAgregarProductoJSON (retorno :any)
        {
            //console.log('retorno del agregarJson:',retorno);
            let oDecodificado = JSON.parse(retorno);
            console.log(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            alert(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            Manejadora.MostrarProductosJSON();

            // alert(JSON.parse(retorno).mensaje);
            // console.log(JSON.parse(retorno).mensaje);
        }

        static successMostrarProductosJSON(retorno :string)
        {
            let oDecodificado = JSON.parse(retorno);
            let tabla ="<table><tr><th>Nombre</th><th>Origen</th></tr>"
            oDecodificado.forEach((element:any) => {
                tabla +=`<tr><td>${element.nombre}</td><td>${element.origen}</td></tr>`;
            });
            tabla+="</table>";
            (<HTMLInputElement>document.getElementById('divTabla')).innerHTML=tabla;
        }
        
        static successVerificarProductoJSON(retorno :string)
        {
            let oDecodificado = JSON.parse(retorno);
            console.log(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            alert(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            Manejadora.MostrarProductosJSON();
        }

        static successMostrarCookie(retorno : string)
        {
            let oDecodificado = JSON.parse(retorno);
            console.log(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            alert(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
        }
        

        static successAgregarProductoSinFoto(retorno : string)
        {
            let oDecodificado = JSON.parse(retorno);
            console.log(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            alert(`${oDecodificado.exito}-${oDecodificado.mensaje}`);
            Manejadora.MostrarProductosEnvasados();

        }

        //FAIL
        static Fail(retorno : string): void{
            console.clear();
            console.log(retorno);
            alert("Ha ocurrido un ERROR!!(ajax)");
        }
    }


}