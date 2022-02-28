<?php 
/*
Aplicación No 7 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.
*/

$zona_horaria = date('m-d-Y h:i:s a',time());
$mesActual = date('n');// Formato: "3"
$texto = "La estacion del Año es: ";

echo "<h2>Fecha Actual: " . $zona_horaria . "</h2>";

$primavera  = "Primavera";//(3,4,5); // Marzo, abril y mayo
$verano     = "Verano";// Junio, julio y agosto
$otono      = "Otoño";// Septiembre, octubre y noviembre
$invierno = "Invierno";// Diciembre, enero y febrero

switch ($mesActual) {
	case '1':
		$texto = $texto . $invierno;
		break;
	case '2':
		$texto = $texto . $invierno;
		break;
	case '3':
		$texto = $texto . $primavera;
		break;
	case '4':
		$texto = $texto . $primavera;
		break;
	case '5':
		$texto = $texto . $primavera;
		break;
	case '6':
		$texto = $texto . $verano;
		break;
	case '7':
		$texto = $texto . $verano;
		break;
	case '8':
		$texto = $texto . $verano;
		break;
	case '9':
		$texto = $texto . $otono;
		break;
	case '10':
		$texto = $texto . $otono;
		break;
	case '11':
		$texto = $texto . $otono;
		break;
	case '12':
		$texto = $texto . $invierno;
		break;
}

echo "<li>" . $texto;

?>