

function HabilitarFormulario()
{
    let password = "jhossy";
    let textPassword : string = (<HTMLInputElement> document.getElementById("textPassword")).value;

    if(textPassword === password)
    {
        alert("Contraseña Correcta...");
        (<HTMLInputElement> document.getElementById("algo")).disabled = false;
        (<HTMLInputElement> document.getElementById("favcolor")).disabled = false;
        (<HTMLInputElement> document.getElementById("bday")).disabled = false;
        (<HTMLInputElement> document.getElementById("mesanio")).disabled = false;
        (<HTMLInputElement> document.getElementById("email")).disabled = false;
        (<HTMLInputElement> document.getElementById("lenguajes")).disabled = false;
        (<HTMLInputElement> document.getElementById("calificacion")).disabled = false;
        (<HTMLInputElement> document.getElementById("horario")).disabled = false;
        (<HTMLInputElement> document.getElementById("web")).disabled = false;
        (<HTMLInputElement> document.getElementById("bestday")).disabled = false;
        (<HTMLInputElement> document.getElementById("listaBrowser")).disabled = false;
        
        (<HTMLInputElement> document.getElementById("p1")).disabled = false;
        (<HTMLInputElement> document.getElementById("p2")).disabled = false;
        (<HTMLInputElement> document.getElementById("p3")).disabled = false;
        (<HTMLInputElement> document.getElementById("p4")).disabled = false;
        (<HTMLInputElement> document.getElementById("p5")).disabled = false;

        (<HTMLInputElement> document.getElementById("v1")).disabled = false;
        (<HTMLInputElement> document.getElementById("v2")).disabled = false;
        (<HTMLInputElement> document.getElementById("v3")).disabled = false;
        (<HTMLInputElement> document.getElementById("v4")).disabled = false;
        
        (<HTMLInputElement> document.getElementById("cboMail")).disabled = false;

        (<HTMLInputElement> document.getElementById("btnLimpiar")).disabled = false;
        (<HTMLInputElement> document.getElementById("btnEnviar")).disabled = false;

    }else{
        alert("Contraseña incorrecta. Pruebe de nuevo...");
    }
}