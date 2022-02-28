/// <reference path="./ajax.ts" />


namespace Test_eje7
{
    export function obtenerDatoJSON():void {

        let pagina : string = "./traerAutoPHP.php";
        let ajax : Ajax = new Ajax();
    
        ajax.Post(pagina, 
            (resultado:any)=> {                
                alert(resultado);
            }
            , "", Fail);    
    }
    
    
    function Fail(retorno:string):void {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }
}