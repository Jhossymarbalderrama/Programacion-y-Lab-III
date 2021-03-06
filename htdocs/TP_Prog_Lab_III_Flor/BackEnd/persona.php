<?php

abstract class Persona{
    private $_apellido="";
    private $_dni=0;
    private $_nombre="";
    private $_sexo="";

    public function __construct($nombre,$apellido,$dni,$sexo)
    {
        $this->_nombre=$nombre;
        $this->_apellido=$apellido;
        $this->_dni=$dni;
        $this->_sexo=$sexo;
    }

    public function GetNombre(){
        return $this->_nombre;
    }
    public function GetApellido(){
        return $this->_apellido;
    }
    public function GetDni(){
        return $this->_dni;
    }
    public function GetSexo(){
        return $this->_sexo;
    }

    public abstract function Hablar($idioma);

    public function __toString()
    {
        return  $this->GetNombre() . "-" . $this->GetApellido() . "-" .  $this->GetDni() . "-" . $this->GetSexo();
    }



} 

?>