
function MostrarMails()
{

    let x : any = (<HTMLInputElement> document.getElementById("cboMail"));

    for (let index:number = 0; index < x.options.length; index++) {
        if(x.options[index].selected ==true){
            alert(x.options[index].value);
        }
    }
}