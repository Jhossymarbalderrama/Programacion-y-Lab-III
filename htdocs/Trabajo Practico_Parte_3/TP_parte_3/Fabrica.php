<?php
//include "Empleado.php";

class Fabrica
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    public function __construct($razonSocial)
    {
        $this->_empleados =  array();
        $this->_cantidadMaxima = 5;
        $this->_razonSocial = $razonSocial;
    }

    public function AgregarEmpelado(Empleado $emp)
    {
        $rta = false;
       
      

        if(count($this->_empleados) < $this->_cantidadMaxima)
        {
        
            array_push($this->_empleados,$emp);
       
            $this->EliminarEmpleadoRepetidos();
            $rta = true;
        }
        
        return $rta;
    }

    public function CalcularSueldos(){
        $total_Acumulado = 0;

        for($i = 0; $i < count($this->_empleados); $i++)
        {
           $total_Acumulado = $total_Acumulado + $this->_empleados[$i]->GetSueldo();
        }
        
        return $total_Acumulado;
    }
    
    public function EliminarEmpleado(Empleado $emp)
    {
        $rta = false;

        for($i = 0; $i < count($this->_empleados); $i++)
        {
           if($this->_empleados[$i]->GetDni() == $emp->GetDni())
           {
                unset($this->_empleados[$i]);
                sort($this->_empleados, SORT_NATURAL | SORT_FLAG_CASE);
                $retorno = true;
           }
        }

        return $rta;
    }

    private function EliminarEmpleadoRepetidos()
    {   
        $this->_empleados = array_unique($this->_empleados);
    }

    public function __toString()
    {
        print("<b>Suelto total de Empleados: </b>". $this->CalcularSueldos());

        $datos_Fabrica = "<br><b>Cantidad Maxima de Empleados: </b>" . $this->_cantidadMaxima . "<br><b>Razon Social: </b>". $this->_razonSocial . "<br>". 
        "----------------------------------------------------------------------<br>";
        foreach ($this->_empleados as $value) {
            $datos_Fabrica .= $value->__toString() . "----------------------------------------------------------------------<br>";
        }

        return $datos_Fabrica;
    }
}


?>