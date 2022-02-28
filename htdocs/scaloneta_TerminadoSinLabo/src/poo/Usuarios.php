<?php
    require_once('AccesoDatos.php');
    require_once('autentificadora.php');

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Psr7\Response;
    
    
    class Usuario
    {
        public $id;
        public $nombre;
        public $apellido;
        public $correo;
        public $perfil;
        public $clave;
        public $foto;


        public function __construct($id = 0, $nombre = "", $apellido = "", $correo = "", $perfil = "", $clave = "", $foto = NULL)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->correo = $correo;
            $this->perfil = $perfil;
            $this->clave = $clave;
            $this->foto = $foto;
        }

        
        public function TraerUno(Request $request, Response $response, array $args): Response 
		{
			$id = $args['id'];
			$elUsuario = Usuario::TraeUnUsuario($id);

			$newResponse = $response->withStatus(200, "OK");
			$newResponse->getBody()->write(json_encode($elUsuario));	

			return $newResponse->withHeader('Content-Type', 'application/json');
		}


		public static function TraeUnUsuario($id) 
		{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * from usuarios WHERE id = $id");
			$consulta->execute();
			$UsuarioBuscado= $consulta->fetchAll(PDO::FETCH_OBJ);
			return $UsuarioBuscado;		
		}

        public static function TraerUsuarios()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso(); 
            $query = $accesoDatos->RetornarConsulta("SELECT 
                                                    usuarios.id, 
                                                    usuarios.correo, 
                                                    usuarios.clave, 
                                                    usuarios.nombre, 
                                                    usuarios.apellido, 
                                                    usuarios.foto, 
                                                    usuarios.perfil 
                                                    FROM usuarios");
            
            $query->execute();

            $array = $query->fetchAll(PDO::FETCH_OBJ);
            $arrayUsuarios = [];

            foreach($array as $item)
            {                
                $aux = new Usuario($item->id,$item->nombre,$item->apellido,$item->correo,$item->perfil,$item->clave,$item->foto);
                array_push($arrayUsuarios,$aux);
            }

            return $arrayUsuarios;
        }


        public function AltaUsuario(Request $request, Response $response, array $args) : Response
        {
            $param = $request->getParsedBody();
            $json = json_decode($param['usuario']);
            $foto = $request->getUploadedFiles()['foto'];

            $rtaUsuario = new stdClass();
            $rtaUsuario->exito = false;
            $rtaUsuario->mensaje = "Error al agregar.";
            $rtaUsuario->status = 418;
            $ultimoID = -1;

            foreach(self::TraerUsuarios() as $item)
            {
                $ultimoID = $item->id;
            }
            $ultimoID += 1;

            $newResponse = new Response();
            $usuario = new Usuario(0,$json->nombre,$json->apellido,$json->correo,$json->perfil,$json->clave,NULL);

            if($foto != NULL)
            {
                $pathDestino = "../fotosBD/" . $foto->getClientFilename();
                $flag = false;
            
                $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
                $nombreArchivo = $usuario->correo . "_". $ultimoID . "." . $tipoDeArchivo;
                $pathDestino = "../src/fotos/" . $nombreArchivo;

                if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
                {
                    
                    $foto->moveTo($pathDestino);
                    $usuario->foto = $pathDestino;
                    $flag = true;
                    
                }

                if($flag)
                {
                    $retorno = json_decode($usuario->AgregarUno());
                        if($retorno->exito){
                            $rtaUsuario->exito = $retorno->exito;
                            $rtaUsuario->mensaje = "Agregado con exito.";
                            $rtaUsuario->status = 200;

                            $newResponse->getBody()->write(json_encode($rtaUsuario));
                        }else{
                            $rtaUsuario->mensaje = $retorno->mensaje;
                            $newResponse->getBody()->write(json_encode($rtaUsuario));
                        }
                }
            }
            return $newResponse;
        }

        public function AgregarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("INSERT INTO usuarios (nombre, apellido, correo, foto, perfil, clave) VALUES (:nombre, :apellido, :correo, :foto, :perfil, :clave)");

            $query->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $query->bindValue(':correo',$this->correo, PDO::PARAM_STR);            
            $query->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);
            $query->bindValue(':clave',$this->clave, PDO::PARAM_STR);
            $query->bindValue(':foto',$this->foto, PDO::PARAM_STR);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo agregar el usuario";

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

        public function ListadoUsuarios(Request $request, Response $response, array $args): Response 
        {
            $usuarios = Usuario::TraerUsuarios();
            
            $json = new stdClass();
            $json->exito = false;
            $json->mensaje = "No hay usuarios.";
            $json->dato = "";
            $json->status = 424;    
            $newResponse = new Response();

            if(count($usuarios)){
                $json->exito = true;
                $json->mensaje = "Listado de usuarios";
                $json->dato = $usuarios;
                $json->status = 200;

                $newResponse = $response->withStatus(200, "OK");
                $newResponse->getBody()->write(json_encode($json));                
            }

            return $newResponse->withHeader('Content-Type', 'application/json');
        }



        public static function TraerUnoCorreoClave($json)
        {
            $usuario = json_decode($json);
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("SELECT * from usuarios WHERE correo = :correo AND clave = :clave");

            $query->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
            $query->bindValue(':correo', $usuario->correo, PDO::PARAM_STR);

            try
            {
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }
        }

        public function VerificarUsuario(Request $request, Response $response, array $args): Response{

            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->jwt = NULL;
            $retorno->status = 403;
            $newResponse = new Response();

            $params = $request->getParsedBody();

            $user = json_decode($params['user']);
            
            $json = new stdClass();
            $json->correo = $user->correo;
            $json->clave = $user->clave; 

            $usuario = Usuario::TraerUnoCorreoClave(json_encode($json));

            if($usuario != NULL){

                $retorno->jwt = Autentificadora::CrearJWT(json_encode($usuario));
                $retorno->status = 200;
                $retorno->exito = true;

                $newResponse = $response->withStatus(200);
            }
            
            $newResponse->getBody()->write(json_encode($retorno));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }

        public function ObtenerDataJWT(Request $request, Response $response, array $args): Response{

            $respuesta = new stdClass();
            $respuesta->exito = false;
            $respuesta->payload = NULL;
            $respuesta->status = 403;

            $params = $request->getHeader("token")[0];
 
            $datos = Autentificadora::VerificarJWT($params);
            $newResponse = new Response();

            if($datos->verificado){

                $token = Autentificadora::ObtenerPayLoad($params);

                $respuesta->exito = $datos->verificado;
                $respuesta->payload = $token->payload;
                $respuesta->status = 200;

                $newResponse = $response->withStatus(200);
            }

            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }        
    }
?>