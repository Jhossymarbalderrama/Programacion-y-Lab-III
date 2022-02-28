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
            
            $query = $accesoDatos->RetornarConsulta("INSERT INTO auto (color, marca, precio, modelo) VALUES (:color, :marca, :precio, :modelo)");

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


        public static function TraerAutos()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso(); 
            $query = $accesoDatos->RetornarConsulta("SELECT 
                                                    auto.id, 
                                                    auto.color, 
                                                    auto.marca, 
                                                    auto.precio,
                                                    auto.modelo
                                                    FROM auto");
            
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


        public function EliminarAutoPorID(Request $request, Response $response, array $args) : Response
        {
            $token_AutoAEliminar = $request->getHeader("token")[0];
            $id = json_decode($request->getBody());
            
            $retorno = new stdClass();
            $retorno->exito = false;           
            $retorno->status = 418;
            
            $response = new Response();

            $token = Autentificadora::ObtenerPayLoad($token_AutoAEliminar);
            $Data_Auto = json_encode($token->payload);
            $json_token = json_decode($Data_Auto);
            $json = json_decode($json_token->data);

            $retorno->mensaje = "El Usuario ". $json[0]->correo. " No es un Propietario";
        
            if(strtolower($json[0]->perfil) == "propietario"){

                Auto::EliminarAuto($id->id_auto);
                $retorno->exito = true;
                $retorno->mensaje = "El Usuario " . $json[0]->correo . " Elimino al auto con la ID: " . $id->id_auto;
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
            
            $query = $accesoDatos->RetornarConsulta("DELETE FROM auto WHERE id = :id");

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
            $token_AutoAEliminar = $request->getHeader("token")[0];
            $token = Autentificadora::ObtenerPayLoad($token_AutoAEliminar);
            $Data_Auto = json_encode($token->payload);
            $json_token = json_decode($Data_Auto);
            $json = json_decode($json_token->data);

            $json_auto = $request->getBody();

            $newResponse = new Response();
            $respuesta = new stdClass();            
            $respuesta->mensaje = "No se modifico el auto.";
            $respuesta->status = 418;
            $respuesta->exito = false;

            if(strtolower($json[0]->perfil) == "encargado")
            {
                $retornoModificado = json_decode(Auto::ModificarAutomovil($json_auto));


                if($retornoModificado->exito){
    
                    $respuesta->exito = $retornoModificado->exito;
                    $respuesta->mensaje = "Se modifico correctamente.";
                    $respuesta->status = 200;
    
                    $newResponse = $response->withStatus(200);
                }else{
                    $respuesta->mensaje = "Error al modificar.";
                    $newResponse = $response->withStatus(418);
                }
            }else{
                $respuesta->mensaje = "El Usuario ". $json[0]->correo ." no es un Encargado";
            }
           
            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }


        public static function ModificarAutomovil($json)
        {
            $json = json_decode($json);

            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("UPDATE auto SET 
                                                    color = :color, marca = :marca, precio = :precio, modelo = :modelo
                                                    WHERE id = :id");

            $query->bindValue(':color',$json->auto->color, PDO::PARAM_STR);
            $query->bindValue(':marca',$json->auto->marca, PDO::PARAM_STR);
            $query->bindValue(':precio',$json->auto->precio, PDO::PARAM_INT);
            $query->bindValue(':modelo',$json->auto->modelo, PDO::PARAM_STR);
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


        
    }
?>