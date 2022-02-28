

function MostrarVoto()
{
    let nombre : string = (<HTMLInputElement> document.getElementById("textNombre")).value;
    let elemento : NodeListOf<HTMLInputElement> | null =  (document.querySelectorAll('input[name="rdoVoto"]'));
    let flag: number  = 0;

    console.log("-----------------------------------------------------");
    console.log("Nombre: "+nombre);
    if(elemento != null)
    {
        for(let i: number = 0; i < elemento.length; i++)
        {
            if(elemento[i].checked)
            {
                console.log("Voto: "+elemento[i].value);
            }
        }
    }
}