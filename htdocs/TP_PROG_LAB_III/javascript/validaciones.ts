
function AdministrarValidaciones():boolean
{

    let rta = false;
    let dni : string = (<HTMLInputElement> document.getElementById("textDNI")).value;
    let apellido : string = (<HTMLInputElement> document.getElementById("textApellido")).value;
    let nombre : string = (<HTMLInputElement> document.getElementById("textNombre")).value;
    let sexo : string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
    let legajo : string = (<HTMLInputElement> document.getElementById("textLegajo")).value;
    let sueldo : string = (<HTMLInputElement> document.getElementById("textSueldo")).value;
    let foto : string = (<HTMLInputElement> document.getElementById("file")).value; //CAPTURO EL PATH DONDE SE ENCUENTRA LA IMG
  
    let datosPersona : any = new Array(dni,apellido,nombre,sexo,legajo,sueldo,foto);

    ValidacionCamposForm(datosPersona);
    if(dni != "" && apellido != "" && nombre != "" && sexo != "" && legajo != "" && sueldo != ""){
        if(foto != "")
        {
            rta = true;
            Main.CargarDatos();    
        }
        
        if((<HTMLInputElement> document.getElementById("hdnModificar")).value == "ok")
        {
            rta = true;
            Main.CargarDatos();  
        }
    }

    return rta;
}


/**
 * Recibe el valor ID de un campo y lo valido que no este vacio
 * 
 * @param cadena 
 * @returns True si no esta vacio o False caso contrario
 */
function ValidarCamposVacios(cadena : string):boolean
{
    let rta : boolean = false;

    if(cadena.length > 0)
   {
       rta = true;
   }

    return rta;
}


/**
 * Recibe como parametro el valor a ser validado y los valores min y max del rango
 * 
 * @param valor_n 
 * @param min_n 
 * @param max_n 
 * @returns Retorna true si el valor pertenece al rango o false caso contrario
 */
function ValidarRangoNumerico(valor_n: number, min_n : number, max_n : number):boolean
{
     let rta :boolean = false;

    if(valor_n > 0)
    {    
        if(valor_n >= min_n && valor_n <= max_n)
        {
            rta = true;
        }
    }
    
    return rta;    
}

/**
 * Recibe como par??metro el valor del atributo id del combo a ser validado y el valor que no debe de tener 
 * 
 * @param cadena_s 
 * @param sexo_s 
 * @returns Retorna true si no coincide o false caso contrario 
 */
function ValidarCombo(cadena_s : string, sexo_s :string) : boolean
{
    let rta : boolean = false;
    //M o F
    if(cadena_s === sexo_s)
    {
        rta = true;
    }

    return rta;
}


function ObtenerTurnoSeleccionado():string
{

    let elemento : NodeListOf<HTMLInputElement> | null =  (document.querySelectorAll('input[name="rdoTurno"]'));
    let flag: number  = 0;
    let rta : string= "";

    if(elemento != null)
    {
        for(let i: number = 0; i < elemento.length; i++)
        {
            if(elemento[i].checked)
            {
                rta = elemento[i].value;
            }
        }
    }
    return rta;
}


function ObtenerSueldoMaximo(turno_v : string):number
{
    let valor_Maximo : number = 0;

    switch (turno_v) {
        case "Ma??ana":
            valor_Maximo = 20000;
            break;
        case "Tarde":
            valor_Maximo = 18500;
            break;
        case "Noche":
            valor_Maximo = 25000;
            break;
    }

    return valor_Maximo;
}


function AdministrarModificar(dni_Empleado : string):void
{       
    (<HTMLInputElement> document.getElementById("dniHidden")).value = dni_Empleado;
    let myForm = (<HTMLFormElement> document.getElementById("modificarForm"));

    myForm.submit();
}



function ValidacionCamposForm(datosPersona : any):void
{
    for (let index = 0; index < datosPersona.length; index++) {       
        switch (index){
            case 0:
                if(!(ValidarCamposVacios(datosPersona[index]))){
                        AdministrarSpanError("spanDni",true);                  
                }else{
                    if(ValidarRangoNumerico(parseInt(datosPersona[index]),1000000,55000000)){
                        AdministrarSpanError("spanDni",false);    
                    }else{
                        AdministrarSpanError("spanDni",true);
                    }     
                }
                break;
            case 1:                       
                if(!(ValidarCamposVacios(datosPersona[index]))){
                    AdministrarSpanError("spanApellido",true);
                }else{
                    AdministrarSpanError("spanApellido",false);
                }
                break;
            case 2:      
                if(!(ValidarCamposVacios(datosPersona[index]))){
                    AdministrarSpanError("spanNombre",true);
                }else{
                    AdministrarSpanError("spanNombre",false);
                }                         
                break;
            case 3:
                if(ValidarCamposVacios(datosPersona[index])){
                    if(ValidarCombo(datosPersona[index],"")){
                        AdministrarSpanError("spanSexo",true);
                    }    

                    if(ValidarCombo(datosPersona[index],"M") || ValidarCombo(datosPersona[index],"F")){
                        AdministrarSpanError("spanSexo",false);
                    }else{
                        AdministrarSpanError("spanSexo",true);
                    } 
                }else{
                    AdministrarSpanError("spanSexo",true);
                }                      
                break;
            case 4:
                if(ValidarCamposVacios(datosPersona[index])){
                    if(!(ValidarRangoNumerico(datosPersona[index],100,550))){
                        AdministrarSpanError("spanLegajo",true);
                    }else{
                        AdministrarSpanError("spanLegajo",false);
                    }
                }else{
                    AdministrarSpanError("spanLegajo",true);
                }                      
                break;
            case 5:   
                if(ValidarCamposVacios(datosPersona[index])){
                        if(ValidarRangoNumerico(parseInt(datosPersona[index]),8000,ObtenerSueldoMaximo(ObtenerTurnoSeleccionado()))){
                            if((parseInt(datosPersona[index])%2 == 0)){  
                                AdministrarSpanError("spanSueldo",false);                                         
                            }else{                                                                                                        
                                AdministrarSpanError("spanSueldo",true); 
                            }                             
                        }else{                                                     
                            (<HTMLInputElement> document.getElementById("textSueldo")).value = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado()).toString();                                        
                        }                            
                }else{                              
                        AdministrarSpanError("spanSueldo",true);                    
                }             
            break;
            case 6:
                if(ValidarCamposVacios(datosPersona[index]))
                {
                    //Con Archivo
                    AdministrarSpanError("spanFile",false);                                
                }else{
                    //Vacio
                    AdministrarSpanError("spanFile",true);                     
                }
            break;
        }        
    }
}