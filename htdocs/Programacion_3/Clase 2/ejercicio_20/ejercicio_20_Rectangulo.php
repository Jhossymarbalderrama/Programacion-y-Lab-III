<?php
include "ejercicio_20_Punto.php";
/*
    Aplicación No 20 (Rectangulo - Punto)
    Codificar las clases Punto y Rectangulo.

    La clase Punto ha de tener dos atributos privados con acceso de sólo lectura (sólo con getters),
    que serán las coordenadas del punto. Su constructor recibirá las coordenadas del punto.

    La clase Rectangulo tiene los atributos privados de tipo Punto _vertice1, _vertice2, _vertice3 y
    _vertice4 (que corresponden a los cuatro vértices del rectángulo).

    La base de todos los rectángulos de esta clase será siempre horizontal. Por lo tanto, debe tener un
    constructor para construir el rectángulo por medio de los vértices 1 y 3.


    Los atributos ladoUno, ladoDos, área y perímetro se deberán inicializar una vez construido el
    rectángulo.

    Desarrollar una aplicación que muestre todos los datos del rectángulo y lo dibuje en la página.
*/

class Rectangulo extends Punto
{
    private Punto $_vertice1; //HORIZONTAL DEL RECTANGULO
    private Punto $_vertice2;
    private Punto $_vertice3; //HORIZONTAL DEL RECTANGULO
    private Punto $_vertice4;

    public $area = 0;
    public $ladoDos = 0;
    public $ladoUno = 0;
    public $perimetro = 0;


   public function __construct($punto_v1, $punto_v3){
        parent::__construct($punto_v1,$punto_v3);// Le paso el _vertice 1 y 3 a Punto
        /*
            Creo Punto :
                            x = v3 //Horizontal
                            y = v1 //Horizontal
        */
   }

   public function Dibujar(){
        $rta = "";
        $x_dibujo = $this->get_X();
        $y_dibujo = $this->get_Y();
        $dibujo = " ";

        echo "<br>";
        for($i = 1 ; $i<=$y_dibujo ; $i++){                
            /**
             * y = 0
             * y = 1
             * y = 2
             * y = 3
             */
            //print($i);
            
            for($j = 1 ; $j<=$x_dibujo; $j++){
                /**
                 * y = 0 : x = * all
                 * y = 1 : x[0] = * : x[...] = "-" : x[x_dibujo.len-1] = *   
                 * y = 2 : x[0] = * : x[...] = "-" : x[x_dibujo.len-1] = *   
                 * y = 3 : x = * all
                 */
                //print($j);
                
                if($i == 0 || $i <= $y_dibujo){
                    $dibujo = $dibujo . "*";
                }else{
                    //ESTE ELSE ESTA DEMAS
                    if($j = 0 || $j <= $y_dibujo){
                        $dibujo = $dibujo . "*";
                    }else{
                        $dibujo = $dibujo . "-";
                    }
                }

                if($j == $x_dibujo){
                    echo "<br>";
                }       
                        
            }
            
            echo "<br>";
            
            echo($dibujo);
            $dibujo = " ";

           
        }


       return $rta;
   }
}

$test = new Rectangulo(18,4);

print($test->Dibujar());

?>