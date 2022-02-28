"use strict";
///<reference path="./ajax.ts"/>
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.prototype.EliminarProducto = function (objJSON) {
            throw new Error("Method not implemented.");
        };
        Manejadora.prototype.VerificarProductoEnvasado = function () {
            Manejadora.VerificarProductoEnvasado();
        };
        Manejadora.prototype.AgregarProductoFoto = function () {
            Manejadora.AgregarProductoFoto();
        };
        Manejadora.prototype.BorrarProductoFoto = function () {
            throw new Error("Method not implemented.");
        };
        Manejadora.prototype.ModificarProductoFoto = function () {
            throw new Error("Method not implemented.");
        };
        //PARTE 3
        //Mostrar para la parte 3
        Manejadora.MostrarProductosEnvasadosFoto = function () {
            var ajax = new Ajax();
            var params = "tabla=json";
            ajax.Get('../BACKEND/ListadoProductosEnvasados.php', Manejadora.successMostrarProductosEnvasadosFoto, params, Manejadora.Fail);
        };
        Manejadora.successMostrarProductosEnvasadosFoto = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            var tabla = "<table><tr><th>ID</th><th>Nombre</th><th>CodigoBarra</th><th>Origen</th><th>Precio</th><th>Foto</th><th>Acciones</th></tr>";
            oDecodificado.forEach(function (element) {
                tabla += "<tr> <td>" + element.id + "</td>\n                <td>" + element.nombre + "</td>\n                <td>" + element.origen + "</td>\n                <td>" + element.codigoBarra + "</td>\n                <td>" + element.precio + "</td>";
                if (element.pathFoto != null) {
                    tabla += "<td><img src=\"../BACKEND/productos/imagenes/" + element.pathFoto + "\" width='50px' height='50px'></td>";
                }
                else {
                    tabla += "<td>No tiene foto</td>";
                }
                var auxProducto = JSON.stringify(element);
                tabla += "<td> <input type=\"button\" value=\"eliminar\" onclick=PrimerParcial.Manejadora.BorrarProductoFoto('" + auxProducto + "')></td>";
                tabla += "<td> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.ModificarProductoFotoBoton('" + auxProducto + "')></td>";
            });
            tabla += '</tr></table>';
            document.getElementById("divTabla").innerHTML = tabla;
        };
        Manejadora.VerificarProductoEnvasado = function () {
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var ajax = new Ajax();
            var form = new FormData();
            var params = "{\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\"}";
            form.append('obj_producto', params);
            ajax.Post('../BACKEND/VerificarProductoEnvasado.php', Manejadora.succesVerificarProductoEnvasado, form, Manejadora.Fail);
        };
        Manejadora.succesVerificarProductoEnvasado = function (retorno) {
            document.getElementById("divInfo").innerHTML = retorno;
        };
        Manejadora.AgregarProductoFoto = function () {
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var precio = document.getElementById("precio").value;
            var foto = document.getElementById("foto").files;
            var codigoBarra = document.getElementById("codigoBarra").value;
            var ajax = new Ajax();
            var form = new FormData();
            form.append('nombre', nombre);
            form.append('origen', origen);
            form.append('precio', precio);
            form.append('foto', foto[0]);
            form.append('codigoBarra', codigoBarra);
            ajax.Post('../BACKEND/AgregarProductoEnvasado.php', Manejadora.succesAgregarProductoFoto, form, Manejadora.Fail);
        };
        Manejadora.succesAgregarProductoFoto = function (retorno) {
            console.log(retorno);
            alert(retorno);
            Manejadora.MostrarProductosEnvasadosFoto();
        };
        // BorrarProductoFoto. Recibe como parámetro al objeto JSON que se ha de eliminar. Pedir confirmación,
        // mostrando nombre y código de barra, antes de eliminar.
        // Si se confirma se invocará (por AJAX) a “./BACKEND/BorrarProductoEnvasado.php” que recibe el parámetro
        // producto_json (id, codigoBarra, nombre, origen, precio y pathFoto en formato de cadena JSON) por POST. Se deberá borrar el
        // producto envasado (invocando al método Eliminar).
        // Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert lo acontecido. Refrescar el listado para visualizar los cambios.
        Manejadora.BorrarProductoFoto = function (objJSON) {
            var objDecoEliminar = JSON.parse(objJSON);
            var respuesta = window.confirm("Esta seguro de eliminar el producto NOMBRE: " + objDecoEliminar.nombre + " CODIGOBARRA: " + objDecoEliminar.codigoBarra + "?");
            //let params = "producto_json="+ objJSON;
            var form = new FormData();
            var params = "{\"id\":\"" + objDecoEliminar.id + "\",\"nombre\":\"" + objDecoEliminar.nombre + "\",\"origen\":\"" + objDecoEliminar.origen + "\",\"codigoBarra\":\"" + objDecoEliminar.codigoBarra + "\",\"precio\":\"" + objDecoEliminar.precio + "\",\"foto\":\"" + objDecoEliminar.pathFoto + "\"}";
            form.append('producto_json', params);
            if (respuesta == true) {
                var ajax = new Ajax();
                ajax.Post("../BACKEND/BorrarProductoEnvasado.php", Manejadora.succesBorrarProductoFoto, form, Manejadora.Fail);
            }
        };
        Manejadora.succesBorrarProductoFoto = function (retorno) {
            console.log(retorno);
            alert(retorno);
            Manejadora.MostrarProductosEnvasadosFoto();
        };
        //Modificar 
        //         ModificarProductoFoto. Mostrará todos los datos del producto que recibe por parámetro (objeto JSON), en el
        // formulario, de tener foto, incluirla en “imgFoto”. Permitirá modificar cualquier campo (incluyendo la foto), a
        // excepción del id.
        // Al pulsar el botón Modificar (de la página) se invocará (por AJAX) a
        // “./BACKEND/ModificarProductoEnvadadoFoto.php” dónde se recibirán por POST los siguientes valores: producto_json
        Manejadora.ModificarProductoFotoBoton = function (json) {
            var producto = JSON.parse(json);
            if (producto.pathFoto != null) {
                var foto = "../BACKEND/productos/imagenes/" + producto.pathFoto.toString();
                document.getElementById("imgFoto").src = foto;
            }
            else {
                document.getElementById("imgFoto").src = "../producto_default.jpg";
            }
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("codigoBarra").value = producto.codigoBarra.toString();
            document.getElementById("precio").value = producto.precio.toString();
            document.getElementById("cboOrigen").value = producto.origen;
        };
        Manejadora.ModificarProductoFoto = function () {
            alert("Estoy en modificar con foto");
            var id = parseInt(document.getElementById("idProducto").value);
            var nombre = document.getElementById("nombre").value;
            var codigoBarra = parseInt(document.getElementById("codigoBarra").value);
            var precio = parseInt(document.getElementById("precio").value);
            var origen = document.getElementById("cboOrigen").value;
            var foto = document.getElementById("foto").files;
            var ajax = new Ajax();
            var params = "{\"id\":" + id + ",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"codigoBarra\":" + codigoBarra + ",\"precio\":" + precio + "}";
            var form = new FormData();
            form.append('producto_json', params);
            form.append('foto', foto[0]);
            ajax.Post('../BACKEND/ModificarProductoEnvadadoFoto.php', Manejadora.successModificarProductoFoto, form, Manejadora.Fail);
        };
        Manejadora.successModificarProductoFoto = function (cadena) {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(cadena);
            alert(cadena);
        };
        //PARTE 2
        //SIN INTERFAZ
        Manejadora.EliminarProductoBoton = function (objJSON) {
            //let auxObj : any = JSON.stringify(objJSON);
            var objDecoEliminar = JSON.parse(objJSON);
            var respuesta = window.confirm("Esta seguro de eliminar el producto: " + objDecoEliminar.nombre + " origen:" + objDecoEliminar.origen + "?");
            var params = "producto_json=" + objJSON;
            if (respuesta == true) {
                var ajax = new Ajax();
                ajax.Post("../BACKEND/EliminarProductoEnvasado.php", Manejadora.succesEliminarProducto, params, Manejadora.Fail);
            }
        };
        Manejadora.succesEliminarProducto = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            console.log(oDecodificado.exito + "-" + oDecodificado.mensaje);
            alert(oDecodificado.exito + "-" + oDecodificado.mensaje);
            Manejadora.MostrarProductosJSON();
        };
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
        Manejadora.prototype.ModificarProducto = function () {
            throw new Error("Method not implemented.");
        };
        //Interfaz trucha xd
        // EliminarProducto(objJSON : string): void 
        // {
        //     Manejadora.EliminarProductoBoton(objJSON);
        // }
        Manejadora.ModificarProducto = function () {
            var id = document.getElementById("idProducto").value;
            var nombre = document.getElementById("nombre").value;
            var codigoBarra = document.getElementById("codigoBarra").value;
            var precio = document.getElementById("precio").value;
            var origen = document.getElementById("cboOrigen").value;
            var ajax = new Ajax();
            var params = "{\"id\":" + id + ",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"codigoBarra\":" + codigoBarra + ",\"precio\":" + precio + "}";
            var form = new FormData();
            form.append('producto_json', params);
            ajax.Post('../BACKEND/ModificarProductoEnvadado.php', Manejadora.succesModificar, form, Manejadora.Fail);
        };
        Manejadora.ModificarProductoBoton = function (json) {
            var producto = JSON.parse(json);
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("codigoBarra").value = producto.codigoBarra.toString();
            document.getElementById("precio").value = producto.precio.toString();
            document.getElementById("cboOrigen").value = producto.origen.toString();
        };
        Manejadora.succesModificar = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            console.log(oDecodificado.exito + "-" + oDecodificado.mensaje);
            alert(oDecodificado.exito + "-" + oDecodificado.mensaje);
            //Manejadora.MostrarProductosJSON();
            Manejadora.MostrarProductosEnvasados();
        };
        //         AgregarProductoJSON. Obtiene el nombre y el origen desde la página producto.html y se enviará (por AJAX)
        // hacia “./BACKEND/AltaProductoJSON.php” que invoca al método GuardarJSON pasándole
        // './BACKEND/archivos/productos.json' cómo parámetro para que agregue al producto en el archivo. Retornará un JSON que
        // contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert el mensaje recibido.
        Manejadora.AgregarProductoJSON = function () {
            var nombre = document.getElementById("nombre").value;
            console.log(nombre);
            var origen = document.getElementById("cboOrigen").value;
            var paramsForm = new FormData();
            paramsForm.append("nombre", nombre);
            paramsForm.append("origen", origen);
            var ajax = new Ajax();
            ajax.Post("../BACKEND/AltaProductoJSON.php", Manejadora.successAgregarProductoJSON, paramsForm, Manejadora.Fail);
            // ajax.Post("../../BACKEND/AltaProductoJSON.php",Manejadora.successAgregar,paramsForm,Manejadora.Fail);  
        };
        Manejadora.MostrarProductosJSON = function () {
            var ajax = new Ajax();
            ajax.Get('../BACKEND/ListadoProductosJSON.php', this.successMostrarProductosJSON, '', Manejadora.Fail);
        };
        Manejadora.VerificarProductoJSON = function () {
            var ajax = new Ajax();
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var paramsForm = new FormData();
            paramsForm.append('nombre', nombre);
            paramsForm.append('origen', origen);
            ajax.Post('../BACKEND/VerificarProductoJSON.php', Manejadora.successVerificarProductoJSON, paramsForm, Manejadora.Fail);
        };
        Manejadora.MostrarInfoCookie = function () {
            var ajax = new Ajax();
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var params = "nombre=" + nombre + "&origen=" + origen;
            ajax.Get('../BACKEND/MostrarCookie.php', Manejadora.successMostrarCookie, params, Manejadora.Fail);
        };
        //         Obtiene el código de barra, el nombre, el origen y el precio desde la página
        // producto.html, y se enviará (por AJAX) hacia “./BACKEND/AgregarProductoSinFoto.php” que recibe por POST el
        // parámetro producto_json (codigoBarra, nombre, origen y precio), en formato de cadena JSON. Se invocará al método Agregar.
        // Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert el mensaje recibido.
        Manejadora.AgregarProductoSinFoto = function () {
            var ajax = new Ajax();
            var nombreI = document.getElementById("nombre").value;
            var origenI = document.getElementById("cboOrigen").value;
            var codigoBarraI = document.getElementById("codigoBarra").value;
            var precioI = document.getElementById("precio").value;
            var objeto = { codigoBarra: codigoBarraI, nombre: nombreI, origen: origenI, precio: precioI };
            var params = "producto_json" + ("=" + JSON.stringify(objeto));
            ajax.Post('../BACKEND/AgregarProductoSinFoto.php', Manejadora.successAgregarProductoSinFoto, params, Manejadora.Fail);
        };
        Manejadora.MostrarProductosEnvasados = function () {
            var ajax = new Ajax();
            var params = "tabla=json";
            ajax.Get('../BACKEND/ListadoProductosEnvasados.php', Manejadora.successMostrarProductosEnvasados, params, Manejadora.Fail);
        };
        Manejadora.successMostrarProductosEnvasados = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            var tabla = "<table><tr><th>ID</th><th>Nombre</th><th>CodigoBarra</th><th>Origen</th><th>Precio</th><th>Foto</th><th>Acciones</th></tr>";
            oDecodificado.forEach(function (element) {
                tabla += "<tr> <td>" + element.id + "</td>\n                <td>" + element.nombre + "</td>\n                <td>" + element.origen + "</td>\n                <td>" + element.codigoBarra + "</td>\n                <td>" + element.precio + "</td>";
                if (element.pathFoto != null) {
                    tabla += "<td><img src=\"../BACKEND/productos/imagenes/" + element.pathFoto + "\" width='50px' height='50px'></td>";
                }
                else {
                    tabla += "<td>No tiene foto</td>";
                }
                var auxProducto = JSON.stringify(element);
                // tabla += `<td> <input type="button" value="eliminar" onclick=PrimerParcial.Manejadora.EliminarProductoBoton('${auxProducto}')></td>`; Este funciona,sin Interz
                tabla += "<td> <input type=\"button\" value=\"eliminar\" onclick=PrimerParcial.Manejadora.EliminarProductoBoton('" + auxProducto + "')></td>";
                tabla += "<td> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.ModificarProductoBoton('" + auxProducto + "')></td>";
            });
            tabla += '</tr></table>';
            document.getElementById("divTabla").innerHTML = tabla;
        };
        //SUCCESS (Manejadora.)
        Manejadora.successAgregarProductoJSON = function (retorno) {
            //console.log('retorno del agregarJson:',retorno);
            var oDecodificado = JSON.parse(retorno);
            console.log(oDecodificado.exito + "-" + oDecodificado.mensaje);
            alert(oDecodificado.exito + "-" + oDecodificado.mensaje);
            Manejadora.MostrarProductosJSON();
            // alert(JSON.parse(retorno).mensaje);
            // console.log(JSON.parse(retorno).mensaje);
        };
        Manejadora.successMostrarProductosJSON = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            var tabla = "<table><tr><th>Nombre</th><th>Origen</th></tr>";
            oDecodificado.forEach(function (element) {
                tabla += "<tr><td>" + element.nombre + "</td><td>" + element.origen + "</td></tr>";
            });
            tabla += "</table>";
            document.getElementById('divTabla').innerHTML = tabla;
        };
        Manejadora.successVerificarProductoJSON = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            console.log(oDecodificado.exito + "-" + oDecodificado.mensaje);
            alert(oDecodificado.exito + "-" + oDecodificado.mensaje);
            Manejadora.MostrarProductosJSON();
        };
        Manejadora.successMostrarCookie = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            console.log(oDecodificado.exito + "-" + oDecodificado.mensaje);
            alert(oDecodificado.exito + "-" + oDecodificado.mensaje);
        };
        Manejadora.successAgregarProductoSinFoto = function (retorno) {
            var oDecodificado = JSON.parse(retorno);
            console.log(oDecodificado.exito + "-" + oDecodificado.mensaje);
            alert(oDecodificado.exito + "-" + oDecodificado.mensaje);
            Manejadora.MostrarProductosEnvasados();
        };
        //FAIL
        Manejadora.Fail = function (retorno) {
            console.clear();
            console.log(retorno);
            alert("Ha ocurrido un ERROR!!(ajax)");
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
//# sourceMappingURL=Manejadora.js.map