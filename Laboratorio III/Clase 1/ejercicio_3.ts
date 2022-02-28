/*
3. Realizar una función que reciba un parámetro requerido de tipo numérico y otro opcional
    de tipo cadena. Si el segundo parámetro es recibido, se mostrará tantas veces por
    consola, como lo indique el primer parámetro. En caso de no recibir el segundo
    parámetro, se mostrará el valor inverso del primer parámetro.
*/

function funcion_test(valor:number, cadena?:string ):void {
    if(cadena)
    {
        let i = 0;
        for(i = 0;i<=valor+1;i++)
        {
            console.log(cadena);
        }
    }else{
        console.log("-"+valor);
    }
}

//funcion_test(7);
funcion_test(5, "Juan");