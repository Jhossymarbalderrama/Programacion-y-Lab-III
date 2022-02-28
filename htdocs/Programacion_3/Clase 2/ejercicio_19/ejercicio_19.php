<?php
/*
    Aplicación No 19 (Figuras geométricas)
    La clase FiguraGeometrica posee: todos sus atributos protegidos, un constructor por defecto, un
    método getter y setter para el atributo _color, un método virtual (ToString) y dos métodos
    abstractos: Dibujar (público) y CalcularDatos (protegido).

    CalcularDatos será invocado en el constructor de la clase derivada que corresponda, su
    funcionalidad será la de inicializar los atributos _superficie y _perimetro.

    Dibujar, retornará un string (con el color que corresponda) formando la figura geométrica del objeto
    que lo invoque (retornar una serie de asteriscos que modele el objeto).
    Ejemplo:
          *       *******
         ***      *******
        *****     *******
*/

abstract class FiguraGeometrica
{
    protected $_color;

    //CONSTRUCTOR
    public function __construct($valor_)
    {
        $this->_color = $valor_;
    }

    //GETER
	public function get_Color()
	{
		return $this->_color;
	}

    //SETER
    public function set_Color($color_p)
    {
        $this->_color = $color_p;
    }


    //METODOS
    public abstract function Dibujar();

    protected abstract function CalcularDatos($valor_ , $valor_2);

    //TOSTRING
    public function __toString()
    {
        return "*";   
    }

}


?>