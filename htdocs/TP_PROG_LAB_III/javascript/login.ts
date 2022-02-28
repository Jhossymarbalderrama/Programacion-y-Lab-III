
function AdministrarValidacionesLogin()
{
    VerificarValidacionesLogin();
}


function AdministrarSpanError(id : string, elemento : boolean):void
{
    let spanID = (<HTMLInputElement> document.getElementById(id));
    if(elemento){
        spanID.style.display = "block";
    }else{
        spanID.style.display = "none";
    }
}

function VerificarValidacionesLogin():boolean
{
    
    let dni : string = (<HTMLInputElement> document.getElementById("dni")).value;
    let apellido : string = (<HTMLInputElement> document.getElementById("apellido")).value;
    let rta : boolean = false;



    if(!(ValidarCamposVacios(dni.toString()))){
        AdministrarSpanError("spanDni",true);
    }else{
        if(ValidarRangoNumerico(parseInt(dni),1000000,55000000)){
            AdministrarSpanError("spanDni",false);    
            rta = true;
        }else{
            AdministrarSpanError("spanDni",true);
        }     
    }

    if(!ValidarCamposVacios(apellido)){
        AdministrarSpanError("spanApellido",true);
        rta = false;
    }else{
        AdministrarSpanError("spanApellido",false);
        rta = true;
    }


    return rta;
}