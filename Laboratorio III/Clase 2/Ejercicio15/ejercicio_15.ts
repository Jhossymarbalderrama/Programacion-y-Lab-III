

function MostrarDato():void{

    let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
    let pais : number = parseInt((<HTMLInputElement> document.getElementById("pais")).value);

    alert("Su nombre es: "+nombre+" y su pais es: "+descripcion_Pais(pais));

}

function descripcion_Pais(numero:number):string{
    let valor : string = "No se encontro pais";

    if(paises[numero] != null)
    {
        valor = paises[numero].toString();
    }

    return valor;
}

enum paises{
    "Argentina",
    "España",
    "México",
    "Guatemala",
    "Honduras",
    "El Salvador",
    "Venezuela",
    "Colombia",
    "Cuba",
    "Bolivia",
    "Ecuador",
    "Uruguay",
}