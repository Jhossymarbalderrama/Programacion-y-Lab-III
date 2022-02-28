function AdministrarValidacionesLogin () : void
{
    if(!VerificarValidacionesLogin())
    {
        alert("Error");
    }

}

/*
Es la encargada de, según el parámetro
booleano, ocultar o no al elemento cuyo id coincida con el parámetro de tipo string.
 */
function AdministrarSpanError(cadena : string, booleano : boolean) : void
{
    let spanId= (<HTMLInputElement> document.getElementById(cadena));
    if(booleano)
    {
        spanId.style.display="block";
    }else{
        spanId.style.display="none";
    }
}

/**
 VerificarValidacionesLogin(): boolean. Deberá determinar si todos los campos del formulario
están validados. Retornará true, si ningún <span> posee display:block como valor del atributo
style, false caso contrario.
 */

function VerificarValidacionesLogin() :boolean
{
    let retorno : boolean =true;

    let dni :string = (<HTMLInputElement> document.getElementById("txtDni")).value;
    let apellido :string = (<HTMLInputElement> document.getElementById("txtApellido")).value;

    if(!ValidarCamposVacios(dni) ||!ValidarCamposVacios(apellido))
    {
        alert("Uno o varios campos se encuentran sin completar");
        AdministrarSpanError("spanDni",true);
        AdministrarSpanError("spanApellido",true);
        
        if(!ValidarRangoNumerico(parseInt(dni),1000000,55000000))
        {
            alert("El dni no se encuentra dentro de los limites");
        }
    }
    else{
        retorno=true;
    }
     return retorno;
}
