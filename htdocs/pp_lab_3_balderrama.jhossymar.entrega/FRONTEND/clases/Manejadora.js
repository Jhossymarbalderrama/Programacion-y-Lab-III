"use strict";
/// <reference path="ajax.ts"/>
/// <reference path="ProductoEnvasado.ts"/>
/// <reference path="Producto.ts" />
/// <reference path="Iparte2.ts"/>
/// <reference path="Iparte3.ts"/>
/// <reference path="Iparte4.ts"/> 
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarProductoJSON = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/AltaProductoJSON.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var param = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post(path, Manejadora.AgregarProductoJSONSuccess, param, Manejadora.Fail);
        };
        Manejadora.AgregarProductoJSONSuccess = function (cadena) {
            Manejadora.MostrarProductosJSON();
            console.log(cadena);
            alert(cadena);
        };
        Manejadora.MostrarProductosJSON = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/ListadoProductosJSON.php";
            ajax.Get(path, Manejadora.MostrarProductosJSONSuccess, "", Manejadora.Fail);
        };
        Manejadora.MostrarProductosJSONSuccess = function (cadenaProductos) {
            var Productos = JSON.parse(cadenaProductos);
            var div = "<table>\n                <thead>\n                    <tr>\n                        <th>Nombre</th>\n                        <th>Origen</th>\n                    </tr>\n                </thead>\n            ";
            Productos.forEach(function (producto) {
                div += "\n                <tr>\n                    <td>" + producto.nombre + "</td>\n                    <td>" + producto.origen + "</td>\n                </tr>\n                ";
            });
            div += "</table>";
            console.log(cadenaProductos);
            document.getElementById("divTabla").innerHTML = div;
        };
        Manejadora.VerificarProductoJSON = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/VerificarProductoJSON.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var form = new FormData();
            form.append('nombre', nombre);
            form.append('origen', origen);
            ajax.Post(path, Manejadora.AgregarProductoJSONSuccess, form, Manejadora.Fail);
        };
        Manejadora.MostrarInfoCookie = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/MostrarCookie.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var param = "nombre=" + nombre + "&origen=" + origen;
            ajax.Get(path, Manejadora.MostrarInfoCookieSuccess, param, Manejadora.Fail);
        };
        Manejadora.MostrarInfoCookieSuccess = function (cadena) {
            console.log(cadena);
            document.getElementById("divInfo").innerHTML = cadena;
        };
        Manejadora.AgregarProductoSinFoto = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/AgregarProductoSinFoto.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigoBarra = document.getElementById("codigoBarra").value;
            var precio = document.getElementById("precio").value;
            var form = new FormData();
            var params = "{\"codigoBarra\":" + codigoBarra + ",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"precio\":" + precio + "}";
            form.append('producto_json', params);
            ajax.Post(path, Manejadora.AgregarProductoSinFotoSuccess, form, Manejadora.Fail);
        };
        Manejadora.AgregarProductoSinFotoSuccess = function (cadena) {
            Manejadora.MostrarProductosEnvasados();
            console.log(cadena);
            alert(cadena);
        };
        Manejadora.MostrarProductosEnvasados = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/ListadoProductosEnvasados.php";
            var param = 'tabla=json';
            ajax.Get(path, Manejadora.MostrarProductosEnvasadosSuccess, param, Manejadora.Fail);
        };
        Manejadora.MostrarProductosEnvasadosSuccess = function (cadena) {
            console.log(cadena);
            var Productos = JSON.parse(cadena);
            var div = "<table>\n                <thead>\n                    <tr>\n                        <th>Id</th>\n                        <th>Nombre</th>\n                        <th>Origen</th>\n                        <th>Codigo_Barra</th>\n                        <th>Precio</th>\n                        <th>Foto</th>                        \n                    </tr>\n                </thead>\n            ";
            Productos.forEach(function (producto) {
                div += "\n                <tr>    \n                    <td>" + producto.id + "</td>\n                    <td>" + producto.nombre + "</td>\n                    <td>" + producto.origen + "</td>\n                    <td>" + producto.codigoBarra + "</td>\n                    <td>" + producto.precio + "</td>                    \n                ";
                if (producto.pathFoto != null) {
                    div += "\n                        <td>\n                            <img src= ./BACKEND/" + producto.pathFoto + " alt=fotoProd width=50px height=50px>\n                        </td>\n                    ";
                }
                else {
                    div += "\n                        <td>\n                            Sin Foto\n                        </td>\n                    ";
                }
                var auxJson = JSON.stringify(producto);
                div += "<td> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.btn_ModificarProducto('" + auxJson + "')></td>";
                div += "<td> <input type=\"button\" value=\"eliminar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.EliminarProducto('" + auxJson + "')></td>";
            });
            div += "</tr></table>";
            document.getElementById("divTabla").innerHTML = div;
        };
        Manejadora.prototype.EliminarProducto = function (json) {
            Manejadora.EliminarProducto(json);
        };
        Manejadora.EliminarProducto = function (json) {
            var ajax = new Ajax();
            var path = "./BACKEND/EliminarProductoEnvasado.php";
            var producto = JSON.parse(json);
            var nombre = producto.nombre;
            var origen = producto.origen;
            if (confirm("Desea borrar al empleado nombre: " + nombre + ", correo: " + origen + "?")) {
                var params = "producto_json=" + json;
                ajax.Post(path, Manejadora.EliminarProductoSuccess, params, Manejadora.Fail);
            }
        };
        Manejadora.EliminarProductoSuccess = function (cadena) {
            Manejadora.MostrarProductosEnvasados();
            console.log(cadena);
            alert(cadena);
        };
        Manejadora.prototype.ModificarProducto = function () {
            Manejadora.ModificarProducto();
        };
        Manejadora.ModificarProducto = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/ModificarProductoEnvadado.php";
            var id = parseInt(document.getElementById("idProducto").value);
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigo_barra = parseInt(document.getElementById("codigoBarra").value);
            var precio = parseInt(document.getElementById("precio").value);
            var form = new FormData();
            var params = "{\"id\":" + id + ",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"codigoBarra\":" + codigo_barra + ",\"precio\":" + precio + "}";
            form.append('producto_json', params);
            ajax.Post(path, Manejadora.ModificarProductoSuccess, form, Manejadora.Fail);
        };
        Manejadora.ModificarProductoSuccess = function (cadena) {
            Manejadora.MostrarProductosEnvasados();
            console.log(cadena);
            alert(cadena);
        };
        Manejadora.btn_ModificarProducto = function (json) {
            var producto = JSON.parse(json);
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("codigoBarra").value = producto.codigoBarra.toString();
            document.getElementById("precio").value = producto.precio.toString();
            document.getElementById("cboOrigen").value = producto.origen;
        };
        Manejadora.prototype.VerificarProductoEnvsado = function () {
            Manejadora.VerificarProductoEnvsado();
        };
        Manejadora.VerificarProductoEnvsado = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/VerificarProductoEnvasado.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var form = new FormData();
            var jsonDatos = "{\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\"}";
            form.append('obj_producto', jsonDatos);
            ajax.Post(path, Manejadora.VerificarProductoEnvsadoSuccess, form, Manejadora.Fail);
        };
        Manejadora.VerificarProductoEnvsadoSuccess = function (cadena) {
            console.log(cadena);
            document.getElementById("divInfo").innerHTML = cadena;
        };
        Manejadora.prototype.AgregarProductoFoto = function () {
            Manejadora.AgregarProductoFoto();
        };
        Manejadora.AgregarProductoFoto = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/AgregarProductoEnvasado.php";
            var codigo_barra = document.getElementById("codigoBarra").value;
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var precio = document.getElementById("precio").value;
            var foto = document.getElementById("foto").files;
            var form = new FormData();
            form.append("codigoBarra", codigo_barra);
            form.append("nombre", nombre);
            form.append("origen", origen);
            form.append("precio", precio);
            form.append("foto", foto[0]);
            ajax.Post(path, Manejadora.AgregarProductoFotoSuccess, form, Manejadora.Fail);
        };
        Manejadora.AgregarProductoFotoSuccess = function (cadena) {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(cadena);
            alert(cadena);
        };
        Manejadora.MostrarProductosEnvasadosFoto = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/ListadoProductosEnvasados.php";
            var param = 'tabla=json';
            ajax.Get(path, Manejadora.MostrarProductosEnvasadosFotoSuccess, param, Manejadora.Fail);
        };
        Manejadora.MostrarProductosEnvasadosFotoSuccess = function (cadena) {
            console.log(cadena);
            var Productos = JSON.parse(cadena);
            var div = "<table>\n                <thead>\n                    <tr>\n                        <th>Id</th>\n                        <th>Nombre</th>\n                        <th>Origen</th>\n                        <th>Codigo_Barra</th>\n                        <th>Precio</th>\n                        <th>Foto</th>                        \n                    </tr>\n                </thead>\n            ";
            Productos.forEach(function (producto) {
                div += "\n                <tr>    \n                    <td>" + producto.id + "</td>\n                    <td>" + producto.nombre + "</td>\n                    <td>" + producto.origen + "</td>\n                    <td>" + producto.codigoBarra + "</td>\n                    <td>" + producto.precio + "</td>                    \n                ";
                if (producto.pathFoto != null) {
                    div += "\n                        <td>\n                            <img src= ./BACKEND/" + producto.pathFoto + " alt=fotoProd width=50px height=50px>\n                        </td>\n                    ";
                }
                else {
                    div += "\n                        <td>\n                            Sin Foto\n                        </td>\n                    ";
                }
                var auxJson = JSON.stringify(producto);
                div += "<td> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.btn_ModificarProductFoto('" + auxJson + "')></td>";
                div += "<td> <input type=\"button\" value=\"eliminar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.BorrarProductoFoto('" + auxJson + "')></td>";
            });
            div += "</tr></table>";
            document.getElementById("divTabla").innerHTML = div;
        };
        Manejadora.prototype.BorrarProductoFoto = function (json) {
            Manejadora.BorrarProductoFoto(json);
        };
        Manejadora.BorrarProductoFoto = function (json) {
            var ajax = new Ajax();
            var path = "./BACKEND/BorrarProductoEnvasado.php";
            var producto = JSON.parse(json);
            var nombre = producto.nombre;
            var codigoBarra = producto.codigoBarra;
            if (confirm("Desea borrar al Producto nombre: " + nombre + ", codigoBarra: " + codigoBarra + "?")) {
                var params = "producto_json=" + json;
                ajax.Post(path, Manejadora.BorrarProductoFotoSuccess, params, Manejadora.Fail);
            }
        };
        Manejadora.BorrarProductoFotoSuccess = function (cadena) {
            Manejadora.MostrarProductosEnvasados();
            console.log(cadena);
            alert(cadena);
        };
        Manejadora.prototype.ModificarProductoFoto = function () {
            Manejadora.ModificarProductoFoto();
        };
        Manejadora.btn_ModificarProductFoto = function (json) {
            var producto = JSON.parse(json);
            if (producto.pathFoto != null) {
                var foto = "./BACKEND/" + producto.pathFoto.toString();
                document.getElementById("imgFoto").src = foto;
            }
            else {
                document.getElementById("imgFoto").src = "./producto_default.jpg";
            }
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("codigoBarra").value = producto.codigoBarra.toString();
            document.getElementById("precio").value = producto.precio.toString();
            document.getElementById("cboOrigen").value = producto.origen;
        };
        Manejadora.ModificarProductoFoto = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/ModificarProductoEnvadado.php";
            var id = parseInt(document.getElementById("idProducto").value);
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigo_barra = parseInt(document.getElementById("codigoBarra").value);
            var precio = parseInt(document.getElementById("precio").value);
            var foto = document.getElementById("foto").files;
            var form = new FormData();
            var params = "{\"id\":" + id + ",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"codigoBarra\":" + codigo_barra + ",\"precio\":" + precio + "}";
            form.append('producto_json', params);
            form.append('foto', foto[0]);
            ajax.Post(path, Manejadora.ModificarProductoSuccess, form, Manejadora.Fail);
        };
        Manejadora.ModificarProductoFotoSuccess = function (cadena) {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(cadena);
            alert(cadena);
        };
        Manejadora.prototype.MostrarBorradosJSON = function () {
            Manejadora.MostrarBorradosJSON();
        };
        Manejadora.MostrarBorradosJSON = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/MostrarBorradosJSON.php";
            ajax.Post(path, Manejadora.MostrarBorradosJSONSuccess);
        };
        Manejadora.MostrarBorradosJSONSuccess = function (cadena) {
            console.log(cadena);
            document.getElementById("divTabla").innerHTML = cadena;
        };
        Manejadora.prototype.MostrarFotosModificados = function () {
            Manejadora.MostrarFotosModificados();
        };
        Manejadora.MostrarFotosModificados = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/MostrarFotosDeModificados.php";
            ajax.Post(path, Manejadora.MostrarFotosModificadosSuccess);
        };
        Manejadora.MostrarFotosModificadosSuccess = function (cadena) {
            document.getElementById("divTabla").innerHTML = cadena;
        };
        Manejadora.prototype.FiltrarListado = function () {
            Manejadora.FiltrarListado();
        };
        Manejadora.FiltrarListado = function () {
            var ajax = new Ajax();
            var path = "./BACKEND/FiltrarProductos.php";
            var origen = document.getElementById("cboOrigen").value;
            var form = new FormData();
            form.append("origen", origen);
            ajax.Post(path, Manejadora.FiltrarListadoSuccess, form, Manejadora.Fail);
        };
        Manejadora.FiltrarListadoSuccess = function (cadena) {
            document.getElementById("divTabla").innerHTML = cadena;
        };
        Manejadora.Fail = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
//# sourceMappingURL=Manejadora.js.map