<?php
    include "Empleado.php";
    include "Fabrica.php";

    print("<h2>-Test Datos de Un Empleado-</h2>");
    $array_idioma = ["Español","Ingles","Frances"];
    $test_E = new Empleado("Jhossy","Balderrama",45654584,"M",19444,45000,"Mañana");
    print($test_E->__toString());
    print($test_E->Hablar($array_idioma)); 


    print("<h2>-Muestro los datos de la fabrica por defecto-</h2>");
    $test_Fabrica = new Fabrica("CA-VLB");
    print($test_Fabrica->__toString());

    
    $test_Emp_0 = new Empleado("Juan","perez",48715448,"M",14855,50000,"noche");
    $test_Emp_1 = new Empleado("Jhossy","Balderrama",45654584,"M",19444,45000,"mañana");
    $test_Emp_2 = new Empleado("Ana","Gomez",45778524,"F",14775,45000,"mañana");
    $test_Emp_3 = new Empleado("Ema","Lopez",45753322,"M",13887,30000,"noche");

    $test_Fabrica->AgregarEmpelado($test_Emp_0);
    $test_Fabrica->AgregarEmpelado($test_Emp_1);
    $test_Fabrica->AgregarEmpelado($test_Emp_1);
    $test_Fabrica->AgregarEmpelado($test_Emp_2);
    $test_Fabrica->AgregarEmpelado($test_Emp_3);
    print($test_Fabrica->__toString());
    
    print("<br>******************************************<br>");

    $test_Remove_E = new Empleado("Jhossy","Balderrama",45654584,"M",19444,45000,"mañana");
    $test_Fabrica->EliminarEmpleado($test_Remove_E);
   
    print($test_Fabrica->__toString());
?>