namespace Test
{
    export function ejercicio_1():void
    {
        console.clear();
        //objeto simple
        let persona : any = { "codigoBarra" : 1012214511412141224552, "nombre" : "Dulce de Leche", "precio" : "$120"};
        
        alert("Codigo de barra: " + persona.codigoBarra + " - Nombre: " + persona.nombre+ " - precio: " + persona.precio);
        console.log("Codigo de barra: " + persona.codigoBarra + " - Nombre: " + persona.nombre+ " - precio: " + persona.precio);
        console.log("\n");
        console.log(persona["codigoBarra"] + " - " + persona["nombre"] + " - " + persona["precio"]);        

    }


}