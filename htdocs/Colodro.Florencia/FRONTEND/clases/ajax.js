"use strict";
var Ajax = /** @class */ (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            console.log(ruta);
            console.log(params);
            _this._xhr.open('GET', ruta);
            _this._xhr.send();
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        //this._xhr.responseText='nombre=Holita,origen=Argentina';
                        //console.log('Este es el xhr:');
                        //console.log(this._xhr);
                        // console.log('Esto es el xhr response text: ');
                        // console.log(this._xhr.responseURL);
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            _this._xhr.open('POST', ruta, true);
            if (typeof (params) == "string") {
                _this._xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            }
            else {
                _this._xhr.setRequestHeader("enctype", "multipart/form-data");
            }
            _this._xhr.send(params);
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this._xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
//# sourceMappingURL=ajax.js.map