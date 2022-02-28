"use strict";
var Entidades;
(function (Entidades) {
    var Producto = /** @class */ (function () {
        function Producto(nombre, origen) {
            this.nombre = nombre;
            this.origen = origen;
        }
        Producto.prototype.ToString = function () {
            // return `"nombre":"${this.nombe}","origen":"${this.origen}",`
            return JSON.stringify(this);
        };
        Producto.prototype.ToJSon = function () {
            return JSON.parse(this.ToString());
        };
        return Producto;
    }());
    Entidades.Producto = Producto;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=Producto.js.map