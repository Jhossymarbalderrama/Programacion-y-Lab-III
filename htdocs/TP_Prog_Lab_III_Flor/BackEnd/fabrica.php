<?php

require_once "empleado.php";
require_once "interfaces.php";

class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $empleados;
    private $_razonSocial;

    public function __construct($razonSocial, $_cantidadMaxima)
    {
        $this->_razonSocial=$razonSocial;
        $this->empleados= array();
        $this->_cantidadMaxima=$_cantidadMaxima;
    }

    public function GetEmpleados()
    {
        return $this->empleados;
    }
    public function AgregarEmpleado(Empleado $emp){
        $retorno=false;
        if( count($this->empleados) < $this->_cantidadMaxima){

            array_push($this->empleados,$emp);
            $this->EmpleadosRepetido();
            $retorno=true;
        }
        return $retorno;
    }

    public function CalcularSueldos(){
        $totalAcumulado=0;

     foreach($this->empleados as $empleado)
     {
         $totalAcumulado = ($totalAcumulado + $empleado->GetSueldo());
     }
        return $totalAcumulado;
    }

    public function EliminarEmpleado(Empleado $emp){
       $retorno =false;
        for($i = 0; $i < count($this->empleados); $i++)
        {
           if($this->empleados[$i]->GetLegajo()== $emp->GetLegajo())
           {
                unset($this->empleados[$i]);
                sort($this->empleados, SORT_NATURAL | SORT_FLAG_CASE);
                $this->GuardarEnArchivo("../archivos/empleados.txt");
                $retorno = true;
                break;
           }
        }
        return $retorno;
    }

    private function EmpleadosRepetido(){
        $this->empleados = array_unique($this->empleados);
    }

    /*ToString. Retorna un string mostrando todos los datos de la fábrica (incluidos sus empleados), separados por un guión medio (-). */

    public function __toString()
    {
        $retorno = "<br>Razon social: ". $this->_razonSocial . " Cantidad maxima: ".$this->_cantidadMaxima ."<br>";
        foreach($this->empleados as $empleado){
            $retorno .= $empleado->__toString();
        }
        return $retorno;
    }

    public function TraerDeArchivo($nombreArchivo)
    {        
        if(file_exists($nombreArchivo)){
            $archivo = fopen($nombreArchivo,"r");

            while(!feof($archivo))
            {
                $empleado = fgets($archivo);                
                $empleado = is_string($empleado) ? trim($empleado) : false;

                $array_aux = explode("-",$empleado);
                
                if(count($array_aux)>0){
                    if($array_aux[0] != "" && $array_aux[0] != "\r\n"){
                        
                        $cargaEmpleado = new Empleado($array_aux[0],
                                                      $array_aux[1],
                                                      $array_aux[2],
                                                      $array_aux[3],
                                                      $array_aux[4],
                                                      $array_aux[5],
                                                      $array_aux[6]);
                        $cargaEmpleado->SetPathFoto($array_aux[7]);
                        $this->AgregarEmpleado($cargaEmpleado);                                                      
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

            foreach ($this->empleados as $value) {
                $datos = $value->__toString();
                fwrite($archivo,$datos);                
            }
            fclose($archivo);
        }
    }


    // /*TraerDeArchivo. Recibe el nombre del archivo de texto donde se encuentran los empleados 
    // (empleados.txt). Por cada registro leído, genera un objeto de tipo Empleado y lo agrega a la 
    // fábrica (utilizando el método AgregarEmpleado) */
    // public function TraerDeArchivo($nombreArchivo)
    // {
    //     if(file_exists($nombreArchivo)){
    //         $archivo = fopen($nombreArchivo,"r");
    //         while(!feof($archivo))
    //         {
    //             $empleado = fgets($archivo);                
    //             $empleado = is_string($empleado) ? trim($empleado) : false;

    //             $array_aux = explode("-",$empleado);
                
    //             if(count($array_aux)>0){
    //                 if($array_aux[0] != "" && $array_aux[0] != "\r\n"){
                        
    //                     $cargaEmpleado = new Empleado($array_aux[0],
    //                                                   $array_aux[1],
    //                                                   $array_aux[2],
    //                                                   $array_aux[3],
    //                                                   $array_aux[4],
    //                                                   $array_aux[5],
    //                                                   $array_aux[6]);
    //                     $this->AgregarEmpleado($cargaEmpleado);                                                      
    //                 }                                   
    //             }                                                              
    //         }
    //         fclose($archivo);
    //     }       
    // }

    // /**
    //  * Guarda los datos de la fabrica en el txt
    //  */
    // public function GuardarEnArchivo($nombreArchivo)
    // {
    //     if(file_exists($nombreArchivo))
    //     {
    //         $archivo = fopen($nombreArchivo, "w");
    //         foreach ($this->empleados as $value) {
    //             $unEmpleado = $value->__toString();
    //             fwrite($archivo,$unEmpleado);
    //         }
    //         fclose($archivo);
    //     }
    // }
    
}


?>