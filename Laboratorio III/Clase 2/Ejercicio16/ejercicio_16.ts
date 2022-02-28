


function MostrarDatos():void{
    let nombre : string = (<HTMLInputElement> document.getElementById("Nombre")).value;
    let apellido : string = (<HTMLInputElement> document.getElementById("Apellido")).value;
    let dni : string = (<HTMLInputElement> document.getElementById("DNI")).value;
    let mail : string = (<HTMLInputElement> document.getElementById("Mail")).value;
    let curriculum : string = (<HTMLInputElement> document.getElementById("Curriculum")).value;


    console.log(toString(nombre,apellido,dni,curriculum,mail));
}

function toString(nombre:string,apellido:string,dni:string,curriculum:string,mail:string):string
{
    let detalles :string = "";

    detalles = detalles + "Nombre: "+nombre+"\n";
    detalles = detalles + "Apellidos: "+apellido+"\n";
    detalles = detalles + "DNI: "+dni+"\n";
    detalles = detalles + "Mail: "+mail+"\n";
    detalles = detalles + "Curriculum: "+curriculum+"\n";

    return detalles;
}