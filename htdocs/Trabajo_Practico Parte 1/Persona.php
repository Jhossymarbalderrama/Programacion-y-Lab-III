<?php

abstract class Persona
{
    /**Atributos */
    private $_apellido = "";
    private $_dni = 0;
    private $_nombre = "";
    private $_sexo = "";


    /**Constructores */
    public function __construct($nombre, $apellido, $dni, $sexo)
    {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_dni = $dni;
        $this->_sexo = $sexo;
    }


    /**Getters */
    public function getApellido()
	{
		return $this->_apellido;
	}
    public function getNombre()
	{
		return $this->_nombre;
	}
    public function getDni()
	{
		return $this->_dni;
	}
    public function GetSexo()
	{
		return $this->_sexo;
	}

    /**Metodos */

    /**
     * Param: idioma ARRAY[]
     * Return: String
     */
    public abstract function Hablar($idioma);

    public function __toString()
    {
        return "<b>DATOS PERSONA</b> <br> <b>Nombre:</b> " . $this->getNombre() . "<br><b>Apellido: </b>" . $this->getApellido() . "<br><b>DNI: </b>" . $this->getDni() . "<br><b>Sexo: </b>" . $this->GetSexo() . "<br>";
    }
}


?>