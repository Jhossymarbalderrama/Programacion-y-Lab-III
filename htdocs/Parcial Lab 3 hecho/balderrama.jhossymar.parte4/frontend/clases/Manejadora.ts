/// <reference path="ajax.ts"/>
/// <reference path="ProductoEnvasado.ts"/>
/// <reference path="Producto.ts" />
/// <reference path="Iparte2.ts"/>
/// <reference path="Iparte3.ts"/>
/// <reference path="Iparte4.ts"/>

namespace PrimerParcial
{
   export class Manejadora implements Iparte2, Iparte3, Iparte4
   {      
        public static AgregarProductoJSON()
        {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/AltaProductoJSON.php";

            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let param :string = "nombre="+nombre+"&origen="+origen;
            
            ajax.Post(path,Manejadora.AgregarProductoJSONSuccess,param,Manejadora.Fail);
        }

        public static AgregarProductoJSONSuccess(cadena : string):void
        {
            Manejadora.MostrarProductosJSON();
            console.log(cadena);
            alert(cadena);
        }

        public static MostrarProductosJSON():void
        {
            let ajax : Ajax = new Ajax();
            let path = "./clases/backend/ListadoProductosJSON.php";

            ajax.Get(path,Manejadora.MostrarProductosJSONSuccess,"",Manejadora.Fail);
        }

        public static MostrarProductosJSONSuccess(cadenaProductos : string):void
        {
            let Productos : Entidades.Producto[]  = JSON.parse(cadenaProductos);

            let div : string = 
            `<table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Origen</th>
                    </tr>
                </thead>
            `;

            Productos.forEach(producto => {
                div += `
                <tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.origen}</td>
                </tr>
                `;
            });

            div += "</table>";

            (<HTMLInputElement> document.getElementById("divTabla")).innerHTML = div;
        }

        public static VerificarProductoJSON():void
        {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/VerificarProductoJSON.php";

            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;

            let form : FormData = new FormData();
            form.append('nombre',nombre);
            form.append('origen',origen);
            
            ajax.Post(path,Manejadora.AgregarProductoJSONSuccess,form,Manejadora.Fail);
        }

        public static MostrarInfoCookie():void
        {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/MostrarCookie.php";

            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;

            let param : string = "nombre="+nombre+"&origen="+origen;

            ajax.Get(path,Manejadora.MostrarInfoCookieSuccess,param,Manejadora.Fail);
        } 

        public static MostrarInfoCookieSuccess(cadena : string):void
        {            
            console.log(cadena);
            (<HTMLInputElement> document.getElementById("divInfo")).innerHTML = cadena;
        }

        public static AgregarProductoSinFoto() : void
        {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/AgregarProductoSinFoto.php";

            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let codigoBarra : string = (<HTMLInputElement> document.getElementById("codigoBarra")).value;
            let precio : string = (<HTMLInputElement> document.getElementById("precio")).value;

          
            let form : FormData = new FormData();
            let params : string = `{"codigoBarra":${codigoBarra},"nombre":"${nombre}","origen":"${origen}","precio":${precio}}`;

            form.append('producto_json',params);
            
            ajax.Post(path,Manejadora.AgregarProductoSinFotoSuccess,form,Manejadora.Fail);
        }

        public static AgregarProductoSinFotoSuccess(cadena : string) : void
        {
            Manejadora.MostrarProductosEnvasados();
            console.log(cadena);
            alert(cadena);
        }

        public static MostrarProductosEnvasados():void
        {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/ListadoProductosEnvasados.php";
            let param : string = 'tabla=json';

            ajax.Get(path,Manejadora.MostrarProductosEnvasadosSuccess,param,Manejadora.Fail);
        }

        public static MostrarProductosEnvasadosSuccess(cadena : string):void
        {            
            console.log(cadena);
            let Productos : Entidades.ProductoEnvasado[]  = JSON.parse(cadena);
            let div : string = 
            `<table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Origen</th>
                        <th>Codigo_Barra</th>
                        <th>Precio</th>
                        <th>Foto</th>                        
                    </tr>
                </thead>
            `;

            Productos.forEach(producto => {
                div += `
                <tr>    
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.origen}</td>
                    <td>${producto.codigoBarra}</td>
                    <td>${producto.precio}</td>                    
                `;
                if(producto.pathFoto != null)
                {
                    div+=`
                        <td>
                            <img src= clases/backend/${producto.pathFoto} alt=fotoProd width=50px height=50px>
                        </td>
                    `
                }else{
                    div+=`
                        <td>
                            Sin Foto
                        </td>
                    `;
                }
                
                let auxJson = JSON.stringify(producto);
                 div += `<td> <input type="button" value="modificar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.btn_ModificarProducto('${auxJson}')></td>`;
                 div += `<td> <input type="button" value="eliminar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.EliminarProducto('${auxJson}')></td>`;
            });

            div += "</tr></table>";
            
            
            (<HTMLInputElement> document.getElementById("divTabla")).innerHTML = div;
        }

        public EliminarProducto(json : string):void
        {
            alert("xdAnda");
            Manejadora.EliminarProducto(json);            
        }

        public static EliminarProducto(json : string):void
        {
            alert("xdNoAnda");
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/EliminarProductoEnvasado.php";
            let producto : Entidades.ProductoEnvasado = JSON.parse(json);

            let nombre :string = producto.nombre;
            let origen :string = producto.origen;

            if(confirm(`Desea borrar al empleado nombre: ${nombre}, correo: ${origen}?`)){
                let params : string = `producto_json=${json}`;
                ajax.Post(path,Manejadora.EliminarProductoSuccess,params,Manejadora.Fail);
            }           
        }

        public static EliminarProductoSuccess(cadena : string):void
        {
            Manejadora.MostrarProductosEnvasados();

            console.log(cadena);
            alert(cadena);
        }

        public ModificarProducto():void
        {
            Manejadora.ModificarProducto();
        }
        
        public static ModificarProducto():void
        {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/ModificarProductoEnvadado.php";
            
            let id : number = parseInt((<HTMLInputElement> document.getElementById("idProducto")).value);
            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let codigo_barra : number  = parseInt((<HTMLInputElement> document.getElementById("codigoBarra")).value);
            let precio : number = parseInt((<HTMLInputElement> document.getElementById("precio")).value);
         
            let form : FormData = new FormData();
            let params : string = `{"id":${id},"nombre":"${nombre}","origen":"${origen}","codigoBarra":${codigo_barra},"precio":${precio}}`;

            form.append('producto_json',params);

            ajax.Post(path,Manejadora.ModificarProductoSuccess,form,Manejadora.Fail);
        }

        public static ModificarProductoSuccess(cadena : string)
        {
            Manejadora.MostrarProductosEnvasados();
            console.log(cadena);
            alert(cadena);
        }

        public static btn_ModificarProducto(json : string):void
        {
           let producto : Entidades.ProductoEnvasado = JSON.parse(json);
           (<HTMLInputElement> document.getElementById("idProducto")).value = producto.id.toString();
           (<HTMLInputElement> document.getElementById("nombre")).value = producto.nombre;
           (<HTMLInputElement> document.getElementById("codigoBarra")).value = producto.codigoBarra.toString();
           (<HTMLInputElement> document.getElementById("precio")).value = producto.precio.toString();
           (<HTMLInputElement> document.getElementById("cboOrigen")).value = producto.origen;
        }

        public VerificarProductoEnvsado(): void 
        {
            Manejadora.VerificarProductoEnvsado();
        }

        public static VerificarProductoEnvsado(): void {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/VerificarProductoEnvasado.php";

            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let form : FormData = new FormData();
            let jsonDatos = `{"nombre":"${nombre}","origen":"${origen}"}`;
            
            form.append('obj_producto',jsonDatos);

            ajax.Post(path,Manejadora.VerificarProductoEnvsadoSuccess,form,Manejadora.Fail);
        }

        public static VerificarProductoEnvsadoSuccess(cadena : string): void
        {            
            console.log(cadena);
            (<HTMLInputElement> document.getElementById("divInfo")).innerHTML = cadena;
        }

        public AgregarProductoFoto():void
        {
            Manejadora.AgregarProductoFoto();
        }
        
        public static AgregarProductoFoto(): void {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/AgregarProductoEnvasado.php";

            let codigo_barra : string = (<HTMLInputElement> document.getElementById("codigoBarra")).value;
            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let precio : string = (<HTMLInputElement> document.getElementById("precio")).value;
            let foto : any = (<HTMLInputElement> document.getElementById("foto")).files;

            let form : FormData = new FormData();

            form.append("codigoBarra",codigo_barra);
            form.append("nombre",nombre);
            form.append("origen",origen);
            form.append("precio",precio);
            form.append("foto",foto[0]);
            
            ajax.Post(path,Manejadora.AgregarProductoFotoSuccess,form,Manejadora.Fail);
        }

        public static AgregarProductoFotoSuccess(cadena : string): void
        {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(cadena);
            alert(cadena);       
        }      
        
        public static MostrarProductosEnvasadosFoto():void
        {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/ListadoProductosEnvasados.php";
            let param : string = 'tabla=json';

            ajax.Get(path,Manejadora.MostrarProductosEnvasadosFotoSuccess,param,Manejadora.Fail);
        }

        public static MostrarProductosEnvasadosFotoSuccess(cadena : string):void
        {            
            console.log(cadena);
            let Productos : Entidades.ProductoEnvasado[]  = JSON.parse(cadena);
            let div : string = 
            `<table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Origen</th>
                        <th>Codigo_Barra</th>
                        <th>Precio</th>
                        <th>Foto</th>                        
                    </tr>
                </thead>
            `;

            Productos.forEach(producto => {
                div += `
                <tr>    
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.origen}</td>
                    <td>${producto.codigoBarra}</td>
                    <td>${producto.precio}</td>                    
                `;
                if(producto.pathFoto != null)
                {
                    div+=`
                        <td>
                            <img src= clases/backend/${producto.pathFoto} alt=fotoProd width=50px height=50px>
                        </td>
                    `
                }else{
                    div+=`
                        <td>
                            Sin Foto
                        </td>
                    `;                    
                }
                
                let auxJson = JSON.stringify(producto);
                 div += `<td> <input type="button" value="modificar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.btn_ModificarProductFoto('${auxJson}')></td>`;
                 div += `<td> <input type="button" value="eliminar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.BorrarProductoFoto('${auxJson}')></td>`;
            });

            div += "</tr></table>";
            
            
            (<HTMLInputElement> document.getElementById("divTabla")).innerHTML = div;
        }

        public BorrarProductoFoto(json : string): void {
            Manejadora.BorrarProductoFoto(json);
        }

        public static BorrarProductoFoto(json : string): void {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/BorrarProductoEnvasado.php";
            let producto : Entidades.ProductoEnvasado = JSON.parse(json);

            let nombre :string = producto.nombre;
            let codigoBarra :string = producto.codigoBarra;

            if(confirm(`Desea borrar al Producto nombre: ${nombre}, codigoBarra: ${codigoBarra}?`)){
                let params : string = `producto_json=${json}`;
                ajax.Post(path,Manejadora.BorrarProductoFotoSuccess,params,Manejadora.Fail);
            }
        }
        
        public static BorrarProductoFotoSuccess(cadena :string): void {
            Manejadora.MostrarProductosEnvasados();
            console.log(cadena);
            alert(cadena);  
        }


        public ModificarProductoFoto(): void 
        {
            Manejadora.ModificarProductoFoto();
        }

        public static btn_ModificarProductFoto(json : string):void
        {
           let producto : Entidades.ProductoEnvasado = JSON.parse(json);

           if(producto.pathFoto != null){
            let foto : string = "clases/backend/"+producto.pathFoto.toString();
            (<HTMLImageElement>document.getElementById("imgFoto")).src = foto;
           }else{
            (<HTMLImageElement>document.getElementById("imgFoto")).src = "./producto_default.jpg";
           }
        
           (<HTMLInputElement> document.getElementById("idProducto")).value = producto.id.toString();
           (<HTMLInputElement> document.getElementById("nombre")).value = producto.nombre;
           (<HTMLInputElement> document.getElementById("codigoBarra")).value = producto.codigoBarra.toString();
           (<HTMLInputElement> document.getElementById("precio")).value = producto.precio.toString();
           (<HTMLInputElement> document.getElementById("cboOrigen")).value = producto.origen;
          
          
        }

        public static ModificarProductoFoto(): void {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/ModificarProductoEnvadado.php";
            
            let id : number = parseInt((<HTMLInputElement> document.getElementById("idProducto")).value);
            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let codigo_barra : number  = parseInt((<HTMLInputElement> document.getElementById("codigoBarra")).value);
            let precio : number = parseInt((<HTMLInputElement> document.getElementById("precio")).value);
            let foto : any = (<HTMLInputElement> document.getElementById("foto")).files;
            
            let form : FormData = new FormData();
            let params : string = `{"id":${id},"nombre":"${nombre}","origen":"${origen}","codigoBarra":${codigo_barra},"precio":${precio}}`;

            form.append('producto_json',params);
            form.append('foto',foto[0]);
            ajax.Post(path,Manejadora.ModificarProductoSuccess,form,Manejadora.Fail);
        }

        public static ModificarProductoFotoSuccess(cadena : string): void 
        {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(cadena);
            alert(cadena);  
        }

        public MostrarBorradosJSON(): void {
            Manejadora.MostrarBorradosJSON();
        }
        
        public static MostrarBorradosJSON(): void {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/MostrarBorradosJSON.php";

            ajax.Post(path,Manejadora.MostrarBorradosJSONSuccess);
        }
        
        public static MostrarBorradosJSONSuccess(cadena : string): void {
            console.log(cadena);
            (<HTMLInputElement> document.getElementById("divTabla")).innerHTML = cadena;
        }

        public MostrarFotosModificados(): void {
            Manejadora.MostrarFotosModificados();
        }

        public static MostrarFotosModificados(): void {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/MostrarFotosDeModificados.php";

            ajax.Post(path,Manejadora.MostrarFotosModificadosSuccess);
        }

        public static MostrarFotosModificadosSuccess(cadena : string): void {
            (<HTMLInputElement> document.getElementById("divTabla")).innerHTML = cadena;
        }

        public FiltrarListado(): void {
            Manejadora.FiltrarListado();
        }   
        
        public static FiltrarListado(): void {
            let ajax : Ajax = new Ajax();
            let path : string = "./clases/backend/FiltrarProductos.php";
            let origen : string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;

            let form : FormData = new FormData();
            form.append("origen",origen);

            ajax.Post(path,Manejadora.FiltrarListadoSuccess,form,Manejadora.Fail);
        }   

        public static FiltrarListadoSuccess(cadena : string): void {
            (<HTMLInputElement> document.getElementById("divTabla")).innerHTML = cadena;
        }   

        public static Fail(respuesta : string) : void{
            console.log(respuesta);
            alert(respuesta);
        }
   }
}