<?php
 include "ejercicio_1.php";

  $fecha = new DateTime('NOW');   
 

  $fechaContruc = new DXAS($fecha);

  echo strval($fechaContruc);


?>