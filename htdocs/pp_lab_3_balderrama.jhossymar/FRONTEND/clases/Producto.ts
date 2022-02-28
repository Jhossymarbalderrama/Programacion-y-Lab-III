namespace Entidades
{
    export class Producto{
        public nombre : string;
        public origen : string;


        public constructor(nombre : string, origen : string)
        {
            this.nombre = nombre;
            this.origen = origen;
        }

        public  ToJSON()
        {
            return JSON.stringify(this);
        }

        public ToString()
        {
            return this.ToJSON().toString();
        }

    }
}