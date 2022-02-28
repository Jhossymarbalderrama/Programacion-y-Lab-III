<?php
include "ejercicio_19.php";

Class ClaseDerivada extends FiguraGeometrica
{
    protected $_superficie;
    protected $_perimetro;

    public function __construct($valor_, $valor_s , $valor_p)
    {
        parent::__construct($valor_);
        $this->CalcularDatos($valor_s,$valor_p);
    }

    //Seter _superficie
    public function set_superficie($valor_s)
    {
        $this->_superficie = $valor_s;
    }
    //Seter _perimetro
    public function set_perimetro($valor_p)
    {
        $this->_perimetro = $valor_p;
    }

    //METODOS
    public  function Dibujar()
    {
        $color = $this->get_Color();

        for ($i = 0; $i < $this->_perimetro; $i++){
            $vacio = "-";
            for ($k = 1; $k < $this->_perimetro - $i; $k++) {
                $vacio = $vacio . '-';
            }

            for($j = 0; $j < $this->_superficie;$j++)
            {
                $vacio = $vacio . "<font color=$color>". $this->__toString()."</font>";
            }
            $this->set_superficie($this->_superficie+2);
            print("-".$vacio . "<br>");

          }
    }

    protected function CalcularDatos($valor_s , $valor_p)
    {
        $this->set_superficie($valor_s);
        $this->set_perimetro($valor_p);
    }
}

$test = new ClaseDerivada("red",1,50);

print($test->Dibujar());

?>