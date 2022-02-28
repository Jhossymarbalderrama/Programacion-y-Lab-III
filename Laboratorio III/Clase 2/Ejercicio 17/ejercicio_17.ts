
function MostrarDatos()
{
    let elemento : NodeListOf<HTMLInputElement> | null =  (document.querySelectorAll('input[name="pelicula"]'));
    let flag: number  = 0;

    console.log("-----------------------------------------------------");
    console.log("Peliculas Seleccionadas:");
    if(elemento != null)
    {
        for(let i: number = 0; i < elemento.length; i++)
        {
            if(elemento[i].checked)
            {
                console.log("Pelicula: "+elemento[i].value);
            }
        }
    }
}