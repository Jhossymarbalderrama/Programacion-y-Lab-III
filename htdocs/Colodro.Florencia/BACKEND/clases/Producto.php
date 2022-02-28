<?php
class Producto
{
    public $nombre;
    public $origen;

    public function __construct($nombre,$origen)
    {
        $this->nombre=$nombre;
        $this->origen=$origen;
    }
    // un método de instancia ToJSON(), que retornará los datos de la instancia (en una cadena con formato JSON).
    
    public function ToJSON()
    {
        $objGenerico = new stdClass();
        $objGenerico->nombre = $this->nombre;
        $objGenerico->origen = $this->origen;

        return json_encode($objGenerico);
    }

    public function GuardarJSON($path)
    {
        $rtaJSON = new stdClass();
        $rtaJSON->exito = false;
        $rtaJSON->mensaje = "Error. No se guardo el Producto en el Archivo";

        if(file_exists($path))
        {
            $archivo = fopen($path,"r");

            if(filesize($path) > 0)
            {
                $aux = fread($archivo, filesize($path));
            }

            fclose($archivo);

            $archivo = fopen($path,"w");
        }
        else
        {
            $archivo = fopen($path,"a");
        }

        if(filesize($path) == 0)
        {
            if(fwrite($archivo, "[". $this->ToJSON() . "]") != 0)
            {
                $rtaJSON->exito = true;
                $rtaJSON->mensaje = "Se guardo el Producto en el Archivo";
                
            }

            fclose($archivo);
        }
        else
        {
            $lectura = explode("]", $aux);

                if(fwrite($archivo, $lectura[0] . "," . $this->ToJSON() . "]") != 0)
                {
                    $rtaJSON->exito = true;
                    $rtaJSON->mensaje = "Se guardo el Producto en el Archivo";
                }
                fclose($archivo);
        }
        
        return json_encode($rtaJSON);
    }

    public static function TraerJSON($path)
    {
        if(!file_exists($path))
            {
                $Archivo = fopen($path,"w");
                fclose($Archivo);
            }

            $archivo = fopen($path, "r");
            $json = fread($archivo,filesize($path));
            fclose($archivo);
            
            return json_decode($json);
    }


    public static function VerificarProductoJSON($producto)
    {
        $listado = Producto::TraerJson("./archivos/productos.json");

        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No hay producto";

        if($listado !== null && $listado !== 0){
            $countOrigen = 0;
            foreach($listado as $item)
            {
                if($item->origen == $producto->origen){
                    $countOrigen++;
                    if($item->nombre == $producto->nombre){
                        $retornoJson->exito = true;
                    }
                }
            }
         
            if($retornoJson->exito == true){
                $retornoJson->mensaje = "Se encontraron '" . $countOrigen . "' productos con mismo origen.";
            }
            else{
                $arrayValores = array();
                foreach ($listado as $item) {
                    array_push($arrayValores, $item->nombre);
                }
                $arrayNombres = array_count_values($arrayValores);
                // var_dump($arrayNombres);
                // echo "Maximo: " . max($arrayNombres);
                $retornoJson->mensaje = "Listado de los mas populares: ";
                foreach($arrayNombres as $key => $cantidad){
                    if(max($arrayNombres) == $cantidad){
                        $retornoJson->mensaje .= $key . ", ";
                    }
                }
            }
        }
        else{
            $retornoJson->mensaje = "El listado vacio.";
        }
        return json_encode($retornoJson);
    }







}
?>