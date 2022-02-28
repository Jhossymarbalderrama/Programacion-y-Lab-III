<?php
require_once("../vendor/autoload.php");
require_once("../backend/fabrica.php");
require_once("../backend/empleado.php");
require_once("validarSesion.php");
ValidarSession("../login.html");


header('content-type:application/pdf');
/**Listo Los Empleados que tengo */
$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                        'pagenumPrefix' => 'Página nro. ',
                        'pagenumSuffix' => ' - ',
                        'nbpgPrefix' => ' de ',
                        'nbpgSuffix' => ' páginas']);//P-> vertical; L-> horizontal

$mpdf->SetProtection(array(), 'UserPassword', $_SESSION["DNIEmpleado"]);
$mpdf->SetHeader('Balderrama Jhossymar ||{PAGENO}{nbpg}');
//alineado izquierda | centro | alineado derecha
$mpdf->setFooter(__DIR__ . '||{PAGENO}');


if(file_exists("../archivos/empleados.txt"))
{
    $path = "../archivos/empleados.txt"; 
    $fabrica = new Fabrica("SA",7);
    $fabrica->TraerDeArchivo($path);
    $array_Empleados = $fabrica->GetEmpleados();
}

$grilla = '<table class="table" border="1" align="center">
            <thead>
                <tr>
                    <th>  DNI         </th>
                    <th>  NOMBRE     </th>
                    <th>  APELLIDO       </th>
                    <th>  SEXO       </th>
                    <th>  LEGAJO       </th>
                    <th>  SUELDO       </th>
                    <th>  TURNO       </th>
                    <th>  Path       </th>
                    <th>  FOTO       </th>
                </tr> 
            </thead>';   	

foreach ($array_Empleados as $prod){
    $grilla .= "<tr>
                    <td>".$prod->getDni()."</td>
                    <td>".$prod->getNombre()."</td>
                    <td>".$prod->getApellido()."</td>
                    <td>".$prod->GetSexo()."</td>
                    <td>".$prod->GetLegajo()."</td>
                    <td>".$prod->GetSueldo()."</td>
                    <td>".$prod->GetTurno()."</td>
                    <td>".$prod->GetPathFoto()."</td>
                    <td><img src='".$prod->GetPathFoto()."' width='100px' height='100px'/></td>
                </tr>";
}

$grilla .= '</table>';

$mpdf->WriteHTML("<h3>Listado de Empleados</h3>");
$mpdf->WriteHTML("<br>");
$mpdf->WriteHTML($grilla);


$mpdf->Output('Lista_Empleados.pdf', 'I');