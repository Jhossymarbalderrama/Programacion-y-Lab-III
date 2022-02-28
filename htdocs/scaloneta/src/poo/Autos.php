<?php
    require_once('AccesoDatos.php');

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Psr7\Response;

    class Auto
    {
        public $id;
        public $color;
        public $marca;
        public $precio;
        public $modelo;


        public function __construct($id = 0, $color = "", $marca = "", $precio = 0, $modelo = "")
        {
            $this->id = $id;
            $this->color = $color;
            $this->marca = $marca;
            $this->precio = $precio;
            $this->modelo = $modelo;
        }

        public function AltaAuto(Request $request, Response $response, array $args) : Response
        {
            $param = $request->getParsedBody();
            $json = json_decode($param['auto']);

            $rtaAuto = new stdClass();
            $rtaAuto->exito = true;
            $rtaAuto->mensaje = "ERROR al agregar el Auto";
            $rtaAuto->status = 418;

            $newResponse = new Response();
            $auto = new Auto(0,$json->color,$json->marca,$json->precio,$json->modelo);

            $retorno = json_decode($auto->AgregarUno());
            if($retorno->exito){
                $rtaAuto->exito = $retorno->exito;
                $rtaAuto->mensaje = "Agregado con exito.";
                $rtaAuto->status = 200;
                $newResponse->getBody()->write(json_encode($rtaAuto));
            }else{
                $rtaAuto->mensaje = $retorno->mensaje;
                $newResponse->getBody()->write(json_encode($rtaAuto));
            }

            return $newResponse;
        }

        public function AgregarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("INSERT INTO autos (color, marca, precio, modelo) VALUES (:color, :marca, :precio, :modelo)");

            $query->bindValue(':color',$this->color, PDO::PARAM_STR);
            $query->bindValue(':marca',$this->marca, PDO::PARAM_STR);    
            $query->bindValue(':precio',$this->precio, PDO::PARAM_STR);
            $query->bindValue(':modelo',$this->modelo, PDO::PARAM_STR);            

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo agregar el Auto";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->id = $accesoDatos->RetornarUltimoIdInsertado();
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }

        public function ListadoAutos(Request $request, Response $response, array $args): Response 
        {
            $auto = Auto::TraerAutos();

            $json = new stdClass();
            $json->exito = false;
            $json->mensaje = "No hay Autos.";
            $json->dato = "";
            $json->status = 424;    
            $newResponse = new Response();

            if(count($auto)){
                $json->exito = true;
                $json->mensaje = "Listado de Autos";
                $json->dato = $auto;
                $json->status = 200;

                $newResponse = $response->withStatus(200, "OK");
                $newResponse->getBody()->write(json_encode($json));                
            }

            return $newResponse->withHeader('Content-Type', 'application/json');
        }

        public static function TraerAutos()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso(); 
            $query = $accesoDatos->RetornarConsulta("SELECT * FROM autos");
            
            $query->execute();

            $array = $query->fetchAll(PDO::FETCH_OBJ);
            $arrayAutos = [];

            foreach($array as $item)
            {            
                $aux = new Auto($item->id,$item->color,$item->marca,$item->precio,$item->modelo);

                array_push($arrayAutos,$aux);
            }

            return $arrayAutos;
        }


        public function EliminarAutoPorID(Request $request, Response $response, array $args) : Response
        {
            /* $id = $request->getParsedBody(); */            
            $json = $args['id_auto'];
            
            $retorno = new stdClass();
            $retorno->exito = false;   
            $retorno->mensaje = "No se pudo Eliminar el Auto";        
            $retorno->status = 418;
            
            $response = new Response();

            $rtaElimino = Auto::EliminarAuto($json);
            $rtaElimino = json_decode($rtaElimino);
            if($rtaElimino->exito == true)
            {
                    $retorno->exito = true;
                    $retorno->mensaje = "Se Elimino al auto con la ID: " . $json;
                    $retorno->status = 200;
                    $newResponse = $response->withStatus(200);
            }else{
                $newResponse = $response->withStatus(418);
            }
            

            $newResponse->getBody()->write(json_encode($retorno));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }


        public static function EliminarAuto($id)
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("DELETE FROM autos WHERE id = :id");

            $query->bindValue(':id',$id, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo eliminar el auto";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se elimino el auto con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }



        public function ModificarAutoPorID(Request $request, Response $response, array $args) : Response
        {           
            $json = $args['auto'];           
            

            $newResponse = new Response();
            $respuesta = new stdClass();        
            $respuesta->exito = false;    
            $respuesta->mensaje = "No se modifico el auto.";
            $respuesta->status = 418;
            

    
            $retornoModificado = json_decode(Auto::ModificarAutomovil($json));


            if($retornoModificado->exito){

                $respuesta->exito = $retornoModificado->exito;
                $respuesta->mensaje = "Se modifico correctamente.";
                $respuesta->status = 200;

                $newResponse = $response->withStatus(200);
            }else{
                $respuesta->mensaje = "Error al modificar.";
                $newResponse = $response->withStatus(418);
            }
            
           
            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }


        public static function ModificarAutomovil($json)
        {
            $json = json_decode($json);

            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("UPDATE autos SET 
                                                    color = :color, marca = :marca, precio = :precio, modelo = :modelo
                                                    WHERE id = :id");

            $query->bindValue(':color',$json->color, PDO::PARAM_STR);
            $query->bindValue(':marca',$json->marca, PDO::PARAM_STR);
            $query->bindValue(':precio',$json->precio, PDO::PARAM_INT);
            $query->bindValue(':modelo',$json->modelo, PDO::PARAM_STR);
            $query->bindValue(':id',$json->id_auto, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo modificar el auto";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se modifico el auto con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }


        public static function ListAutosHTML(Request $request, Response $response, array $args) : Response
        {
            $responseMW = new Response();          
            $arrayDeAutos = Auto::TraerAutos();

            if(isset($arrayDeAutos)){

                /**
                 * "id": "1",                                           
                 *  "color": "blanco",
                 * "marca": "citroen",
                 * "precio": "197000",
                 * "modelo": "c4"
                 */

                $TableHTML = "<table align='center'>                
                                <tr>
                                    <td>
                                        |
                                    </td>
                                    <td>
                                    <b>ID</b> -
                                    </td>
                                    <td>
                                        <b>COLOR</b> -
                                    </td>
                                    <td>
                                        <b>MARCA</b> -
                                    </td>
                                    <td>
                                        <b>PRECIO</b> -
                                    </td>
                                    <td>
                                        <b>MODELO</b> - 
                                    </td>
                                    <td>
                                        |
                                    </td>
                                </tr>";

                foreach($arrayDeAutos as $item){
                    $TableHTML .= "<tr>
                                    <td>
                                        |
                                    </td>
                                    <td>
                                        $item->id
                                    </td>
                                    <td>
                                        $item->color
                                    </td>
                                    <td>
                                        $item->marca
                                    </td>
                                    <td>
                                        $item->precio
                                    </td>
                                    <td>
                                        $item->modelo
                                    </td>
                                    <td>
                                        |
                                    </td>
                                </tr>";
                }

                $TableHTML .= "</table>";

               /*  echo $TableHTML; */
                $responseMW->getBody()->write(json_encode($TableHTML));                    
            }

            return $responseMW;
        }

    }
?>