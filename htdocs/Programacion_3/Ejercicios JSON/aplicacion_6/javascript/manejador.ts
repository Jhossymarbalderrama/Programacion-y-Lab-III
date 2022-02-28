/// <reference path="./ajax.ts" />


namespace Test_eje6
{
    export function ejercicio_6():void {

        let pagina = "./recibirJson.php";
        
        let ajax : Ajax = new Ajax();

        ajax.Post(pagina, 
            (resultado:string)=> {

                (<HTMLDivElement>document.getElementById("divResultado")).innerHTML = "";

                console.clear();

                console.log(resultado);
                
                /*let objJson = JSON.parse(resultado);
                alert(objJson.codigoBarra + " - "+objJson.nombre + " - " + objJson.precio);
                console.log(objJson.codigoBarra + " - "+objJson.nombre + " - " + objJson.precio);*/

                alert(resultado);
            }
            , "", Fail);
    }

     export function Fail(retorno:string):void {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }

    export function IrHacia(pagina:string):void {
        window.location.href = pagina;
    }
}