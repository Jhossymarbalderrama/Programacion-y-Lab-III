<?php
require_once("persona.php");

class Empleado extends Persona
{
   /**Atributos */
    protected $_legajo = 0;
    protected $_sueldo = 0;
    protected $_turno = "";

    protected $_pathFoto = "";

    /**Constructores */
    public function __construct($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno)
    {
        parent::__construct($nombre, $apellido, $dni, $sexo);
        $this->_legajo = $legajo;
        $this->_sueldo = $sueldo;
        $this->_turno = $turno;
    }

    /**Getters */
    public function GetLegajo()
	{
		return $this->_legajo;
	}
    public function GetSueldo()
	{
		return $this->_sueldo;
	}
    public function GetTurno()
	{
		return $this->_turno;
	}

    public function GetPathFoto()
    {
        return $this->_pathFoto;
    }
    
    /**Setter */
    public function SetPathFoto($foto)
    {
        $this->_pathFoto = $foto;
    }


    /**Metodos */

    /**
     * Param: idioma ARRAY[]
     * Return: String
     */
    public function Hablar($idioma){
        $rta = "<b>El empleado habla: </b>";
        $cant = count($idioma);

        if($cant > 0){
            foreach ($idioma as $value) {
                $rta .=  $value . ",";
            }
        }

        return $rta;
    }

    public function __toString()
    {
        return parent::__toString() . " - " . $this->GetLegajo() . " - " . $this->GetSueldo() . " - " . $this->GetTurno() . " - " . $this->GetPathFoto() . "\n";
    }

}


?>