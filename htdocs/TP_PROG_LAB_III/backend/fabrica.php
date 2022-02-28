<?php
    require_once("empleado.php");
    require_once("IArchivo.php");

class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    public function __construct($razonSocial,$capacidad)
    {
        $this->_empleados =  array();
        $this->_cantidadMaxima = $capacidad;
        $this->_razonSocial = $razonSocial;
    }

    public function GetEmpleados()
	{
        return $this->_empleados;
    }    

    public function AgregarEmpelado(Empleado $emp)
    {
        $rta = false;

        if(count($this->_empleados) < $this->_cantidadMaxima && !$this->LegajoRepetido($emp))
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
           if($this->_empleados[$i]->GetLegajo() == $emp->GetLegajo())
           {
                //unlink($this->_empleados[$i]->GetPathFoto());
                unset($this->_empleados[$i]);
                sort($this->_empleados, SORT_NATURAL | SORT_FLAG_CASE);                
                $this->GuardarEnArchivo("../archivos/empleados.txt");

                $rta = true;
                break;
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


    //Metodos de Interface

    
    /*
        TraerDeArchivo. Recibe el nombre del archivo de texto donde se encuentran los empleados 
        (empleados.txt). Por cada registro leído, genera un objeto de tipo Empleado y lo agrega a la 
        fábrica (utilizando el método AgregarEmpleado).
     */

     //$NombreArchivo = "empleados.txt"
    public function TraerDeArchivo($nombreArchivo)
    {        
        if(file_exists($nombreArchivo)){
            $archivo = fopen($nombreArchivo,"r");

            while(!feof($archivo))
            {
                $empleado = fgets($archivo);                
                $empleado = is_string($empleado) ? trim($empleado) : false;

                $array_aux = explode(" - ",$empleado);
                
                if(count($array_aux)>0){
                    if($array_aux[0] != "" && $array_aux[0] != "\r\n"){
                        
                        if($array_aux[7] != "-")
                        {
                            $cargaEmpleado = new Empleado($array_aux[0],
                                                      $array_aux[1],
                                                      $array_aux[2],
                                                      $array_aux[3],
                                                      $array_aux[4],
                                                      $array_aux[5],
                                                      $array_aux[6]);
                       
                            $cargaEmpleado->SetPathFoto($array_aux[7]);   
                        }                      

                        $this->AgregarEmpelado($cargaEmpleado);                                                                              
                    }                                   
                }                                                              
            }
    
            fclose($archivo);
        }       
    }


    /*
         GuardarEnArchivo. Recibe el nombre del archivo de texto donde se guardarán los 
        empleados de la fábrica (empleados.txt). Recorre el array de Empleados y sobreescribe en 
        el archivo de texto, utilizando el método ToString.
     */
    public function GuardarEnArchivo($nombreArchivo)
    {
        if(file_exists($nombreArchivo)){
            $archivo = fopen($nombreArchivo,"w");

            foreach ($this->_empleados as $value) {
                $datos = $value->__toString();
                fwrite($archivo,$datos);                
            }

            fclose($archivo);
        }
    }
    
    public function LegajoRepetido($empleado)
    {
        $rta = false;

        for ($i=0; $i < count($this->_empleados); $i++) { 
            if($this->_empleados[$i]->GetLegajo() == $empleado->GetLegajo())
            {
                $rta = true;
            }
        }

        return $rta;
    }
}


?>