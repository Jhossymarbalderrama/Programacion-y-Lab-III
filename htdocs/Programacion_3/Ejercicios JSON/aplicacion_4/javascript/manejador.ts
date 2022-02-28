/// <reference path="./ajax.ts" />

namespace Test
{
    export function ejercicio_4():void
    {
        let cadJSON = `[{ "codigoBarra" : 1012214511412141224552, "nombre" : "Dulce de Leche", "precio" : "$120"},
                        { "codigoBarra" : 1012548811412611424552, "nombre" : "Yerba", "precio" : "$350"},
                        { "codigoBarra" : 1012284441412141952252, "nombre" : "Don Satur", "precio" : "$90"}]`;

        let pagina = "./backend/mostrarColeccionJson.php";
        
        let ajax : Ajax = new Ajax();
        let params : string = "misProd=" + cadJSON;   
        alert(params);  
       
        ajax.Post(pagina, 
            (resultado:any)=> {                
                console.log(resultado);
            }
            , params, Fail); 
    }

    function Fail(retorno:string):void {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }

    export function IrHacia(pagina:string):void {
        window.location.href = pagina;
    }
}