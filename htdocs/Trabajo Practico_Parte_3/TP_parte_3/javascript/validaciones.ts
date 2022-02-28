


function AdministrarValidaciones():void
{
    let dni : number = parseInt((<HTMLInputElement> document.getElementById("textDNI")).value);
    let apellido : string = (<HTMLInputElement> document.getElementById("textApellido")).value;
    let nombre : string = (<HTMLInputElement> document.getElementById("textNombre")).value;
    let sexo : string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
    let legajo : number = parseInt((<HTMLInputElement> document.getElementById("textLegajo")).value);
    let sueldo : number = parseInt((<HTMLInputElement> document.getElementById("textSueldo")).value);

  
    let datosPersona : any = new Array(dni.toString(),apellido,nombre,sexo,legajo.toString(),sueldo.toString());

        for (let index = 0; index < datosPersona.length; index++) {       
                switch (index){
                    case 0:
                        if(ValidarCamposVacios(datosPersona[index])){
                            if(!(ValidarRangoNumerico(datosPersona[index],1000000,55000000))){
                                alert("Ingrese un DNI correcto");
                            }    
                        }else{
                            alert("Ingrese un DNI correcto");
                        }  
                        break;
                    case 1:
                        if(!(ValidarCamposVacios(datosPersona[index]))){
                            alert("Ingrese un apellido");
                        }
                        break;
                    case 2:      
                        if(!(ValidarCamposVacios(datosPersona[index]))){
                            alert("Ingrese un nombre");
                        }                            
                        break;
                    case 3:
                        //SEXO
                        if(ValidarCamposVacios(datosPersona[index])){
                            if(ValidarCombo(datosPersona[index],"")){
                                alert("Ingrese un Sexo");
                            }    
        
                            if(ValidarCombo(datosPersona[index],"M") || ValidarCombo(datosPersona[index],"F")){
                            //Sexo correcto M o F
                            }else{
                                alert("Ingrese un Sexo Correcto");
                            } 
                        }else{
                            alert("Ingrese un Sexo Correcto");
                        }  
                    
                        break;
                    case 4:
                        if(ValidarCamposVacios(datosPersona[index])){
                            if(!(ValidarRangoNumerico(datosPersona[index],100,550))){
                                alert("Ingrese un LEGAJO Correcto");
                            } 
                        }else{
                            alert("Ingrese un LEGAJO Correcto");
                        }  
                    
                        break;
                    case 5:   
                        if(isNaN(datosPersona[index])){
                            alert("Ingrese un SUELDO Correcto");                            
                        }else{
                            if(ValidarRangoNumerico(datosPersona[index],8000,ObtenerSueldoMaximo(ObtenerTurnoSeleccionado()))){
                                if(!((datosPersona[index]%2) == 0)){
                                    alert("Ingrese un SUELDO Correcto");     
                                }
                            }else{
                                
                                alert("Ingrese un SUELDO Correcto");   
                                if(datosPersona[index] > ObtenerSueldoMaximo(ObtenerTurnoSeleccionado())){
                                    alert("El sueldo Maximo para su turno es: "+ObtenerSueldoMaximo(ObtenerTurnoSeleccionado()));   
                                }                                      
                            }                        
                        }                        
                    break;
                }
        } 
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
 * Recibe como parámetro el valor del atributo id del combo a ser validado y el valor que no debe de tener 
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
        case "Mañana":
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


