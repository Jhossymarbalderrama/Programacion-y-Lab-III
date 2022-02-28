/// <reference path="ajax.ts" />

window.onload = (): void =>
{
    Main.RefrescarPaginaSuccess();
};

function AddEmployee():void{
    Main.CargarDatos();
}

function DeleteEmployee(legajo:string):void{
    Main.EliminarEmpleado(legajo);  
}

function ModificarEmployee(dni:string):void
{
    Main.ModificarEmpleado(dni);
}

namespace Main 
{  
    export function RefrescarPaginaSuccess():void
    {                
        MostrarForm();
        MostrarEmpleados();
    }

    export function MostrarEmpleados():void
    {
        let ajax : Ajax = new Ajax();
        /* ajax.Post("../../TP_PROG_LAB_III/backend/mostrar.php",
        MostrarEmpleadosSuccess);   */   
        ajax.Post("backend/mostrar.php",
        MostrarEmpleadosSuccess);  
    }

    export function MostrarForm():void
    {     
        let ajax : Ajax = new Ajax();

        /* ajax.Post("../../TP_PROG_LAB_III/index.php",
        MostrarFormSuccess); */   
        ajax.Post("index.php",
        MostrarFormSuccess);
    }
    
    export function MostrarEmpleadosSuccess(empleados:string):void
    {      
        (<HTMLDivElement>document.getElementById("divEmpleados")).innerHTML = empleados; 
    }
    export function MostrarFormSuccess(respuesta: string):void
    {
        (<HTMLDivElement>document.getElementById("divFrm")).innerHTML = respuesta; 
    }
    
    export function EliminarEmpleado(legajo:string):void
    {
        let ajax = new Ajax();
        let parametros: string = `legajo=${legajo}`
        /* ajax.Get("../../TP_PROG_LAB_III/backend/eliminar.php",DeleteSuccess,parametros,Fail); */
        ajax.Get("backend/eliminar.php",DeleteSuccess,parametros,Fail);
    }

    export function DeleteSuccess(retorno: string):void {
        console.clear();
        console.log(retorno);
        MostrarEmpleados();
    }

    export function Fail(retorno:string):void {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    } 

    export function ModificarEmpleado(dni: string): void
    {
        let ajax : Ajax = new Ajax();
        let parametros: string = `dniHidden=${dni}`;      
        ajax.Post("index.php", MostrarFormSuccess, parametros, Fail);
    } 


    export function CargarDatos(): void
    {
        
        let dni: string = (<HTMLInputElement> document.getElementById("textDNI")).value;
        let nombre: string = (<HTMLInputElement> document.getElementById("textNombre")).value;
        let apellido: string = (<HTMLInputElement> document.getElementById("textApellido")).value;
        let sueldo: string = (<HTMLInputElement> document.getElementById("textSueldo")).value;
        let legajo: string = (<HTMLInputElement> document.getElementById("textLegajo")).value;
        let turno: string = ObtenerTurnoSeleccionado();
        let sexo: string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
        let modificar = (<HTMLInputElement>document.getElementById("hdnModificar")).value;
        let foto : any = (<HTMLInputElement>document.getElementById("file")).files;

        let form: FormData = new FormData();


        form.append('file', foto[0]);
        form.append("nombre",nombre);
        form.append("dni",dni);
        form.append("apellido",apellido);
        form.append("sueldo",sueldo);
        form.append("legajo",legajo);
        form.append("rdoTurno",turno);
        form.append("sexo",sexo);
        form.append("hdnModificar",modificar);
        

        MandarEmpleado(form);
    }

    const MandarEmpleado = (form: FormData) =>{
        let ajax = new Ajax();
        ajax.Post("backend/administracion.php", MostrarEmpleadosSuccess, form, Fail);
    }

 
  
}