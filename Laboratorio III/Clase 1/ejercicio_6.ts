/*
6. Realizar una función que reciba como parámetro un número y que retorne el cubo del mismo.
    Nota: La función retornará el cubo del parámetro ingresado. Realizar una función que
    invoque a esta última y permita mostrar por consola el resultado.
*/

function funcion_6(valor:number) :number{
    return Math.pow(valor,3);
}

function mostrar_funcion_6():void{
    console.log("El valor numero al Cubo es: "+funcion_6(3));
}

mostrar_funcion_6();