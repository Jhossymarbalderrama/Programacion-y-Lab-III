
function Saludar():void {

    let dato_1 : string = (<HTMLInputElement> document.getElementById("text1")).value;
    let dato_2 : string = (<HTMLInputElement> document.getElementById("text2")).value;
    let dato_3 : string = (<HTMLInputElement> document.getElementById("text3")).value;
    let dato_4 : string = (<HTMLInputElement> document.getElementById("text4")).value;

    let dato_5 : string = (<HTMLInputElement> document.getElementById("text5")).value;
    let dato_6 : string = (<HTMLInputElement> document.getElementById("text9")).value;
    let dato_7 : string = (<HTMLInputElement> document.getElementById("text13")).value;
    let dato_8 : string = (<HTMLInputElement> document.getElementById("text14")).value;

    let dato_9 : string = (<HTMLInputElement> document.getElementById("text15")).value;
    let dato_10 : string = (<HTMLInputElement> document.getElementById("text16")).value;
    let dato_11 : string = (<HTMLInputElement> document.getElementById("text8")).value;
    let dato_12 : string = (<HTMLInputElement> document.getElementById("text12")).value;

    let lado_1 : number = Suma_Datos(dato_1,dato_2,dato_3,dato_4);
    let lado_2 : number = Suma_Datos(dato_1,dato_5,dato_6,dato_7);
    let lado_3 : number = Suma_Datos(dato_7,dato_8,dato_9,dato_10);
    let lado_4 : number = Suma_Datos(dato_4,dato_11,dato_12,dato_10);


    alert("Los lados son: Lado 1: "+lado_1 + "  - Lado 2: "+lado_2 + " - Lado 3: "+lado_3 + " - Lado 4: "+ lado_4);
    alert("El perimetro es : "+(lado_1+lado_2+lado_3+lado_4));

    (<HTMLInputElement> document.getElementById("text6")).value = "L1: "+lado_1;
    (<HTMLInputElement> document.getElementById("text10")).value = "L2: "+lado_2;
    (<HTMLInputElement> document.getElementById("text7")).value = "L3: "+lado_3;
    (<HTMLInputElement> document.getElementById("text11")).value = "L4: "+lado_4;
}

function Suma_Datos(value_1:string,value_2:string,value_3:string,value_4:string):number{
    return parseInt(value_1)+parseInt(value_2)+parseInt(value_3)+parseInt(value_4);
}
