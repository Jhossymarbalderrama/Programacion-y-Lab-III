function AdministrarValidaciones() : void 
{
    let dni :string = (<HTMLInputElement> document.getElementById("txtDni")).value;
    let apellido :string = (<HTMLInputElement> document.getElementById("txtApellido")).value;
    let nombre :string = (<HTMLInputElement> document.getElementById("txtNombre")).value;
    let sexo :string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
    let legajo :string = (<HTMLInputElement> document.getElementById("txtLegajo")).value;
    let sueldo :string = (<HTMLInputElement> document.getElementById("txtSueldo")).value;
   let sueldoMax : number = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
   let pathFoto : string = (<HTMLInputElement> document.getElementById("pathFoto")).value;

    if (!(ValidarCamposVacios(dni))) {
        AdministrarSpanError("spanDni", true);
    }else {
        if (ValidarRangoNumerico(parseInt(dni), 1000000, 55000000)) {
            AdministrarSpanError("spanDni", false);
        }
        else {
            AdministrarSpanError("spanDni", true);
        }
    }

    if (!(ValidarCamposVacios(apellido))) {
        AdministrarSpanError("spanApellido", true);
    }else {
        AdministrarSpanError("spanApellido", false);
    }


    if (!(ValidarCamposVacios(nombre))) {
        AdministrarSpanError("spanNombre", true);
    }else {
        AdministrarSpanError("spanNombre", false);
    }

    if ((ValidarCombo(sexo, "---"))) {
        AdministrarSpanError("spanSexo", true);
    }else {
        AdministrarSpanError("spanSexo", false);
    }

    if (!(ValidarCamposVacios(legajo))) 
    {
        AdministrarSpanError("spanLegajo", true);
    }else {
        if (ValidarRangoNumerico(parseInt(legajo), 100, 550)) {
            AdministrarSpanError("spanLegajo", false);
        }
        else {
            AdministrarSpanError("spanLegajo", true);
        }
    }

    if (!(ValidarCamposVacios(sueldo))) 
    {
        AdministrarSpanError("spanSueldo", true);
    }else{
        if (ValidarRangoNumerico(parseInt(sueldo), 100, sueldoMax)) {
            AdministrarSpanError("spanSueldo", false);
        }else {
            AdministrarSpanError("spansueldo", true);
        }
    }

    if (!(ValidarCamposVacios(pathFoto))) {
        AdministrarSpanError("spanFoto", true);
    }else {
        AdministrarSpanError("spanFoto", false);
    }

}

/**
 * 
 * @param cadena 
 * @returns 
 */
function ValidarCamposVacios(cadena :string):boolean
{
   let retorno :boolean =false;
   if(cadena.length != 0)
   {
        retorno=true;
   }

    return retorno;
}


function ValidarRangoNumerico(numero :number, min : number, max : number): boolean
{
    let retorno : boolean =false;
    if(numero >= min && numero <=max){
        retorno=true;
    }
    return retorno;
}

function ValidarCombo(elemento:string, sexo:string): boolean
{
    let retorno : boolean=false;
    if(elemento === sexo)
    {
        retorno=true;
    }

    return retorno;
}


function ObtenerTurnoSeleccionado(): string
{
    let retorno : string = "";
    let turnos : any = document.getElementsByName("rdoTurno");

    for(let i =0;i< turnos.length; i++)
    {
        if(turnos[i].checked)
        {
            retorno = turnos[i].value;
        }
    }
    return retorno;
}

function ObtenerSueldoMaximo(turno : string): number
{
    let sueldoMax : number=0;
    switch (turno) {
        case "maniana":
            sueldoMax=20000;
            break;
        case "tarde":
            sueldoMax=18500;
            break;
        case "noche":
            sueldoMax=25000;
        break;    
        default:
            break;
    }
    return sueldoMax;
}

// La función AdministrarModificar deberá establecer el valor del input  (type=hidden) con el valor recibido como parametro y luego ‘submitear’ el formulario que lo contiene.
function AdministrarModificar(dni : string): void
{
    (<HTMLInputElement> document.getElementById("hiddenModificar")).value=dni;
    alert(dni);
    let formModificar =  (<HTMLFormElement> document.getElementById("frmModificar"));//tomar el fomulario por id
    formModificar.submit();//Enviando el formulario 

}