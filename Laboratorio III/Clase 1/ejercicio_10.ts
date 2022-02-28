/*
10. Definir una función que muestre información sobre una cadena de texto que se le pasa
    como argumento. A partir de la cadena que se le pasa, la función determina si esa cadena
    está formada sólo por mayúsculas, sólo por minúsculas o por una mezcla de ambas.
*/


function mostrar_info(cadena:string):void{
    let cont : number = 0;

    var  i = 0;
    for(i = 0; i<cadena.length;i++)
    {
        if(cadena.charAt(i).toLowerCase() == cadena.charAt(i)){    
            //cuento cuantos caracteres de la cadena son minusculas
            cont++;
        }
    }
    
    //verifico si la variable cont es igual a la longitud de la cadena q fue pasada por parametro para determinar si son mayusculas, minusculas o mixtas
    if(cont == cadena.length){
        console.log("Todo los char de la cadena son Minusculas");
    }else if(cont == 0){
        console.log("Todo los char de la cadena son Mayusculas");
    }else{
        console.log("Los char de la cadena son mezcla de ambas");
    }

}


var nombre : string = "Jhossy";


mostrar_info(nombre);

