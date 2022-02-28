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

        public function ValidarParametrosUsuario(Request $request, RequestHandler $handler) :ResponseMW
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
            $retorno->mensaje = "No se paso ni el correo ni la clave.";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            if(isset($params->correo)){
                if(isset($params->clave)){

                    $retorno->status = 200;
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;
                }
                else
                {
                $retorno->mensaje = "No se paso la clave.";
                }
            }
            else if(isset($params->clave))
            {
                $retorno->mensaje = "No se paso el correo.";
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
                /**QUERY Verificando el Correo en la BD*/
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

        public function VerificacionRangoPrecioYColor(Request $request, RequestHandler $handler) :ResponseMW
        {
            $json = $request->getParsedBody();
            $params = json_decode($json["auto"]); 

            $responseMW = new ResponseMW();
            $retorno = new stdClass();
            $retorno->mensaje = "El Precio no se encuentra en el Rango";
            $retorno->status = 409;

            if($params->precio >= 50000 && $params->precio <= 600000)
            {
                if(strtolower($params->color) != "amarillo")
                {
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;
                }else{
                    $retorno->mensaje = "El Color No Puede ser Amarillo";
                }
            }else if(!($params->precio >= 50000 && $params->precio <= 600000) && strtolower($params->color) == "amarillo")
            {
                $retorno->mensaje = "El Precio no se encuentra en el Rango y El color No puede ser Amarillo";
            }

            $responseMW->withStatus(409);
            $responseMW->getBody()->write(json_encode($retorno));    
        
            return $responseMW;
        }


        public function ChequearJWT(Request $request, RequestHandler $handler) :ResponseMW{
            
            $respuesta = new stdClass();
            $respuesta->mensaje = "Token No Valido";
            $respuesta->status = 403;

            $token = $request->getHeader("token")[0];
            $verifyToken = Autentificadora::VerificarJWT($token);
            $newResponse = new ResponseMW();
            if(!$verifyToken->verificado){
                $respuesta->mensaje = $verifyToken;
                $newResponse->getBody()->write(json_encode($respuesta));
            }
            else
            {
                $response = $handler->handle($request);
                $newResponse->getBody()->write((string)$response->getBody());
                return $newResponse->withHeader('Content-Type', 'application/json');
            }
            return  $newResponse;
        }

    
        public static function VerificarPropietario(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];

            $respuesta = new stdClass();            
            $respuesta->propietario = false;
            $respuesta->mensaje = "No es Propietario.";
            $respuesta->status = 409;
           
            
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            $usuario = json_decode($payloadObtenido->payload->data);

            $responseMW = new ResponseMW();


            if(strtolower($usuario[0]->perfil) == "propietario"){

                $respuesta->status = 200;                
                $response = $handler->handle($request);
                $responseMW->withStatus($response->getStatusCode());
                $responseMW->getBody()->write((string)$response->getBody());
                return $responseMW;

            }else{
                $respuesta->mensaje = "El usuario no es propietario, quien quiso realizar la accion es: ". $usuario[0]->correo;
                $respuesta->usuario = $usuario[0];
                $responseMW->withStatus(418);
            }

            $responseMW->getBody()->write(json_encode($respuesta));
            return $responseMW;
        }

        public static function VerificarEncargado(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];

            $respuesta = new stdClass();
            $respuesta->mensaje = "No es encargado.";
            $respuesta->encargado = false;
            $respuesta->status = 409;
            
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            $usuario = json_decode($payloadObtenido->payload->data);

            $responseMW = new ResponseMW();

            if(strtolower($usuario[0]->perfil) == "encargado"){

                $respuesta->status = 200;
                $response = $handler->handle($request);
                $responseMW->withStatus($response->getStatusCode());
                $responseMW->getBody()->write((string)$response->getBody());
                return $responseMW;

            }else{
                $respuesta->mensaje = "El usuario no es encargado, quien quiso realizar la accion es: " . json_encode($usuario[0]);
                $responseMW->withStatus(409);
            }
            
            $responseMW->getBody()->write(json_encode($respuesta));
            return $responseMW;
        }

    

        public function AccedeEncargado(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'encargado'){
        
                        $datosDeAutos = json_decode($response->getBody());
        
                        $arrayDeAutos = $datosDeAutos->dato;
        
                        foreach($arrayDeAutos as $item){

                            unset($item->id);     

                        }
        
                        $datosDeAutos->dato = $arrayDeAutos;
        
                        $responseMW->getBody()->write(json_encode($datosDeAutos));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }

        public function AccedeEmpleado(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'empleado'){
        
                        $datosDeAutos = json_decode($response->getBody());
        
                        $arrayDeAutos = $datosDeAutos->dato;

                        $colores = [];
        
                        foreach($arrayDeAutos as $item){
                            array_push($colores,$item->color);
                        }

                        $cantColores = array_count_values($colores);

                        $rta = new stdClass();

                        $rta->mensaje = "Hay " . count($cantColores) . " colores distintos.";
                        $rta->colores = $cantColores;
                                
                        $responseMW->getBody()->write(json_encode($rta));
                    }
                    else
                    {        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }


        public static function AccedePropietario(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
            $id= isset($request->getHeader("id_auto")[0]) ? isset($request->getHeader("id_auto")[0]) : NULL;

            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'propietario'){
        
                        $datosDeAutos = json_decode($response->getBody());
        
                        $autos = $datosDeAutos->dato;

                        if($id != NULL){
                            foreach($autos as $item){
                                if($item->id == $id){
                                    $autos = $item;
                                }
                            }
                        }
               
                        $responseMW->getBody()->write(json_encode($autos));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }


        public function AccedeEmpleadoB(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if(strtolower($usuario[0]->perfil) == 'empleado'){
        
                        $datosDeUsuarios = json_decode($response->getBody());
        
                        $datosDeUsuarios = $datosDeUsuarios->dato;
        
                        foreach($datosDeUsuarios as $item){
                            unset($item->id);     
                            unset($item->correo);     
                            unset($item->clave);
                            unset($item->perfil);
                        }
        
                        //$datosDeUsuarios->dato = $datosDeUsuarios;
        
                        $responseMW->getBody()->write(json_encode($datosDeUsuarios));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }
        

        public function AccedeEncargadoB(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if(strtolower($usuario[0]->perfil) == 'encargado'){
        
                        $datosDeUsuarios = json_decode($response->getBody());
        
                        $datosDeUsuarios = $datosDeUsuarios->dato;
        
                        foreach($datosDeUsuarios as $item){
                            unset($item->id);     
                            unset($item->clave);   
                        }
        
                        $datosDeUsuarios = $datosDeUsuarios;
        
                        $responseMW->getBody()->write(json_encode($datosDeUsuarios));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }

        public static function AccedePropietarioB(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
            $apellido = isset($request->getHeader("apellido")[0]) ? $request->getHeader("apellido")[0] : NULL;

           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if(strtolower($usuario[0]->perfil) == 'propietario'){
        
                        $datosDeUsuarios = json_decode($response->getBody());
        
                        $datosDeUsuarios = $datosDeUsuarios->dato;
                        $apellidosIguales = [];
                        $todosLosApellidos = [];

                        if($apellido != NULL){
                            foreach($datosDeUsuarios as $item){
                                if($item->apellido == $apellido){
                                    array_push($apellidosIguales,$item);
                                }
                            }

                            if(count($apellidosIguales) == NULL){
                                $cantidad = 0;
                            }else{
                                $cantidad = count($apellidosIguales);
                            }
                            

                            $responseMW->getBody()->write("la cantidad de apellidos iguales es : " . $cantidad);

                        }
                        else
                        {
                            foreach($datosDeUsuarios as $item){
                                array_push($todosLosApellidos,$item->apellido);
                            }

                            $todosLosApellidos = array_count_values($todosLosApellidos);
                            $responseMW->getBody()->write(json_encode($todosLosApellidos));
                        }         
                        
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }
    }

?>