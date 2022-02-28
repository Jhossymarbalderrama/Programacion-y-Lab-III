/*
7. Se necesita mostrar por consola los primeros 20 números primos. Para ello realizar una función.
    Nota: Utilizar console.log()
*/

/**
 * Nro Primeos: 2,3,5,7,11,13,17,19,23,29,31,37,41,43,47,53,59,61,67,71
 * 
 * Numeros Enteros
 * Solo tienen dos divisores: El 1 y ellos mismos
 * El resultado al dividir en un nro entero
 */

function mostrar_Numeros_primos():void{
    var cont :number = 0;
    for (var i = 2; i <= 100; i++) {
        var primo : number = 1;
        var contador : number = 2;

        while(contador <= i/2 && primo) {
            if (i % contador === 0) {
                primo = 0;
            }
            contador++;
        }
        
        if( primo && cont < 20) {
            cont++;
            console.log(cont+" - Nro Primo: "+i);
        }
    }
}

mostrar_Numeros_primos();

