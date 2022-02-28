/*
2. Cree una aplicación que muestre, a través de un Array, los nombres de los meses de un
    año y el número al que ese mes corresponde. Utilizar una estructura repetitiva para
    escribir en la consola (console.log()).
*/

var meses_name : string[] = ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
var i : number = 0;

for(i = 0; i <= meses_name.length-1; i++)
{
    if(i <= 12)
    {
        console.log("Numero: "+(i+1) +" ,Nombre Mes:"+meses_name[i]);    
    }
}
