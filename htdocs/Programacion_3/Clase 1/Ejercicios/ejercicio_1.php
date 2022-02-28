<?php

/*
Aplicación No 1 (Mostrar variables)
Realizar un programa que guarde su nombre en $nombre y su apellido en $apellido. Luego
mostrar el contenido de las variables con el siguiente formato: Pérez, Juan. Utilizar el operador
de concatenación.
*/


/*
$nombre = "Jhossymar";
$apellido = "Balderrama Rocha";

$objDateTime = new DateTime('NOW');
    echo $objDateTime->format('r'); //  formato datetime
    //echo $objDateTime->format(DateTime::ISO8601); // Another way to get an ISO8601 formatted string

echo "<li><b>APELLIDO Y NOMBRE:</b> ".$apellido . $nombre;
*/

class DXAS{
    public DateTime $fecha_t;

    public function __construct(?DateTime $fecha){
        $fecha = new DateTime('NOW');
        $this->fecha_t = $fecha;
    }

}
?>