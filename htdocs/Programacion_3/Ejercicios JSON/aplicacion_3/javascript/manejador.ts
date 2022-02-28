/// <reference path="./ajax.ts" />

namespace Test
{
    export function ejercicio_3():void
    {
        let cadJSON = { "codigoBarra" : 1012214511412141224552, "nombre" : "Dulce de Leche", "precio" : "$120"};
        //let pagina = "../../../../Programacion_3/Ejercicios JSON/aplicacion_3/backend/mostrarJson.php";
        let pagina = "./backend/mostrarJson.php";
        
        let ajax : Ajax = new Ajax();
        let params : string = "miProd=" + JSON.stringify(cadJSON);   
        alert(params);  
       
        ajax.Post(pagina, 
            (resultado:string)=> {                
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