<?php

require_once ("persona.php");

Class Empleado extends Persona
{
    protected $_legajo=0;
    protected $_sueldo=0;
    protected $_turno="";
    protected $_pathFoto="";

    public function __construct($nombre,$apellido,$dni,$sexo, $legajo, $sueldo,$turno)
    {
        parent::__construct($nombre,$apellido,$dni,$sexo);
        $this->_turno=$turno;
        $this->_sueldo=$sueldo;
        $this->_legajo=$legajo;
    }

    public function GetPathFoto()
    {
        return $this->_pathFoto;
    }

    public function SetPathFoto($value)
    {
        $this->_pathFoto=$value;
    }

    public function GetLegajo(){
        return $this->_legajo;
    }

    public function GetSueldo(){
        return $this->_sueldo;
    }

    public function GetTurno(){
        return $this->_turno;
    }

    public function Hablar($idiomas)
    {
        $cadena= "El empleado habla ";
        
        $cantidad = count($idiomas);
        foreach($idiomas as $idioma )
        {
            // if($idiomas[$cantidad-1]{

            // }
            $cadena .= $idioma . " ,";
        }

        return $cadena;
    }

    public function __toString()
    {
        $cadenaToString="";
        
        return $cadenaToString .= parent::__toString() ."-" .$this->GetLegajo() . "-" . $this->GetSueldo() . "-" . $this->GetTurno(). "-" . $this->GetPathFoto() ."\n";
        
    }




}
?>