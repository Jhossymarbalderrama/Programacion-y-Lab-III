"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
///<reference path="Producto.ts"/>
var Entidades;
(function (Entidades) {
    var ProductoEnvasado = /** @class */ (function (_super) {
        __extends(ProductoEnvasado, _super);
        function ProductoEnvasado(nombre, origen, id, codigoBarra, precio, pathFoto) {
            if (id === void 0) { id = 0; }
            if (codigoBarra === void 0) { codigoBarra = 0; }
            if (precio === void 0) { precio = 0; }
            if (pathFoto === void 0) { pathFoto = ''; }
            var _this = _super.call(this, nombre, origen) || this;
            _this.id = id;
            _this.codigoBarra = codigoBarra;
            _this.precio = precio;
            _this.pathFoto = pathFoto;
            return _this;
        }
        ProductoEnvasado.prototype.ToString = function () {
            // return `"id":"${this.id}","codigoBarra":"${this.codigoBarra}","precio":"${this.precio}","pathFoto":"${this.pathFoto}"`
            return JSON.stringify(this);
        };
        ProductoEnvasado.prototype.ToJSon = function () {
            return JSON.parse(this.ToString());
        };
        return ProductoEnvasado;
    }(Entidades.Producto));
    Entidades.ProductoEnvasado = ProductoEnvasado;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=ProductoEnvasado.js.map