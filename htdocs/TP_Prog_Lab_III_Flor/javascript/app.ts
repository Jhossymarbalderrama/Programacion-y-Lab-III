///<reference path="ajax.ts" />


window.onload = ():void => {
    Main.MostrarAltayMostrar();
} 

function AltaEmployee()
{
    Main.CargarEmpleado();
}

namespace Main{
    
        export function MostrarAltayMostrar()
        {
            MostrarGrilla();
            MostrarGrillaAlta();
        }
        export function MostrarGrilla():void {
            let ajax : Ajax = new Ajax();
            ajax.Post("./BackEnd/mostrar.php",MostrarGrillaSuccess);            
        }

        
        export function MostrarGrillaAlta():void {
            let ajax : Ajax = new Ajax();
            ajax.Post("./index.php",MostrarAltaEmpleadosSuccess);            
        }

        export function MostrarGrillaSuccess(grilla:string):void {
            console.clear();
            console.log(grilla);
            (<HTMLDivElement>document.getElementById("idMostrarEmpleados")).innerHTML = grilla;
        }

        function MostrarAltaEmpleadosSuccess(grilla:string):void {
            console.clear();
            console.log(grilla);
            (<HTMLDivElement>document.getElementById("idAltaEmpleado")).innerHTML = grilla;
        }

        //fx q reciba legajo, eliminar elemenpleado se llama desde el mostrar
        export function EliminarEmpleado(legajo : string)
        {
            let ajax : Ajax = new Ajax();
            let parametro = (`txtLegajo=${legajo}`);
            let path = "./BackEnd/eliminar.php";
            ajax.Get(path, MostrarAltayMostrar,parametro);     
        }

        export function ModificarEmpleado(dni : string)
        {
            let ajax : Ajax = new Ajax();
           let parametro = (`hiddenModificar=${dni}`);
            ajax.Post("./index.php", MostrarAltaEmpleadosSuccess,parametro);     
        }

        export function CargarEmpleado ()
        {
            //Agarro los datos del index, hago un formulario y lo envio a admnistracion.php
            let dni :string = (<HTMLInputElement> document.getElementById("txtDni")).value;
            let apellido :string = (<HTMLInputElement> document.getElementById("txtApellido")).value;
            let nombre :string = (<HTMLInputElement> document.getElementById("txtNombre")).value;
            let sexo :string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
            let legajo :string = (<HTMLInputElement> document.getElementById("txtLegajo")).value;
            let sueldo :string = (<HTMLInputElement> document.getElementById("txtSueldo")).value;
            let turno: string = ObtenerTurnoSeleccionado();

            let pathFoto : any = (<HTMLInputElement> document.getElementById("pathFoto")).files;
            let modificar = (<HTMLInputElement>document.getElementById("hdnModificar")).value;


            let formulario: FormData = new FormData();
            formulario.append("txtDni",dni);
            formulario.append("txtApellido",apellido);
            formulario.append("txtNombre",nombre);
            formulario.append("cboSexo",sexo);
            formulario.append("txtLegajo",legajo);
            formulario.append("txtSueldo",sueldo);
            formulario.append("rdoTurno",turno);
            formulario.append("pathFoto",pathFoto[0]);
            formulario.append("hdnModificar",modificar);

            AltaEmpleado(formulario);

        }

        function AltaEmpleado(formulario : FormData)
        {
            let ajax : Ajax = new Ajax();
            ajax.Post("../../TP_Prog_Lab_III_Flor/BackEnd/administracion.php",MostrarGrilla,formulario);     
        }

        

        


      

        function Fail(retorno : string): void{
            console.clear();
            console.log(retorno);
            alert("Ha ocurrido un ERROR!!");
        }

}