<?php
include "empleado.php";
include "fabrica.php";
$empleado1 = new Empleado("Flor","Colo",40242893,"F",1111,10,"Maniana");
$idiomas = ["Español","Ingles","Frances"];

print($empleado1->__toString());
print($empleado1->Hablar($idiomas). "<br>");


$empleado2 = new Empleado("Pepe","Pepino",4023423,"M",3333,100,"Maniana");
$empleado3 = new Empleado("Pepa","Pepina",4024243,"F",2222,200,"Tarde");
$empleado4 = new Empleado("Pepa","Pepina",4024243,"F",2222,200,"Tarde");

$fabrica = new Fabrica("Fabrica xd",5);
$fabrica->AgregarEmpleado($empleado1);
$fabrica->AgregarEmpleado($empleado2);
$fabrica->AgregarEmpleado($empleado3);
$fabrica->AgregarEmpleado($empleado3);
print("<br><b>Informacion de la fabrica:</b>");
print($fabrica->__toString());
echo("Sueldo total: ".$fabrica->CalcularSueldos(). "<br><br>");
print("<br><b>Se elimina un empleado de la fabrica</b>");
$fabrica->EliminarEmpleado($empleado4);
print("<br><b>Informacion de la fabrica:</b>");
print($fabrica->__toString());


?>