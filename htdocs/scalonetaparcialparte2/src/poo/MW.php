<?php
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Psr7\Response;

    require_once('Autos.php');
    require_once('Usuarios.php');    
    require_once('AccesoDatos.php');

    class MW
    {  
        public static function ValidacionParametrosVacios(Request $request, RequestHandler $handler) :ResponseMW
        {
            $json = $request->getParsedBody();

            if(isset($json['user']))
            {
                $params = json_decode($json["user"]);
            }
            else if(isset($json['usuario']))
            {
                $params = json_decode($json["usuario"]);
            }

            $retorno = new stdClass();
            $retorno->mensaje = "El correo y la clave estan vacios.";
            $retorno->status = 409;

            $responseMW = new ResponseMW();

            if($params->correo != ""){
                if($params->clave != ""){
                    
                    $retorno->status = 200;
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;
                }
                else
                {
                $retorno->mensaje = "La clave esta vacia.";
                }
            }
            else if($params->clave != "")
            {
                $retorno->mensaje = "El correo esta vacio.";
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }


        public function VerificarUsuarioBD(Request $request, RequestHandler $handler) :ResponseMW
        {
            $json = $request->getParsedBody();

            $retorno = new stdClass();
            $retorno->mensaje = "El usuario no se encuentra en la base de datos.";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            $json = $request->getParsedBody();

            if(isset($json['user']))
            {
                $usuario = Usuario::TraerUnoCorreoClave($json['user']);
            }

            if(isset($usuario[0])){

                $retorno->mensaje = "El usuario se encuentra en la base de datos.";
                $retorno->status = 200;

                $response = $handler->handle($request);
                $responseMW->withStatus($response->getStatusCode());
                $responseMW->getBody()->write((string)$response->getBody());
                return $responseMW;
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }

        public static function VerificacionExisteBD(Request $request, RequestHandler $handler) :ResponseMW
        {
            $json = $request->getParsedBody();
            $params = json_decode($json["usuario"]); 
            $responseMW = new ResponseMW();        

            $retorno = new stdClass();
            $retorno->mensaje = "El CORREO del Usuario Ya Existe.";
            $retorno->status = 403;

            if(isset($params))
            {                
                $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
                $query = $accesoDatos->RetornarConsulta("SELECT * from usuarios WHERE correo = :correo");
                $query->bindValue(':correo',$params->correo, PDO::PARAM_STR);
    
                try
                {
                    $query->execute();
                    $flag =  $query->fetchAll(PDO::FETCH_OBJ);
                }
                catch(PDOException $e)
                {
                    echo "Error: {$e->getMessage()}";
                }
                if(count($flag) == 0)
                {                   
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;
                }          
                
                $responseMW->withStatus(403);
                $responseMW->getBody()->write(json_encode($retorno));                            
            }
            return $responseMW;  
        }


        

    }

?>