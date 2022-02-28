<?php
    require_once "AccesoDatos.php";

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
		public $foto;
		public $perfil;
		public $clave;


		public function __construct($id = 0, $nombre = "", $apellido = "", $correo = "", $foto = NULL, $perfil = 0, $clave = "")
		{
			$this->id = $id;
			$this->nombre = $nombre;
			$this->apellido = $apellido;
			$this->correo = $correo;
			$this->foto = $foto;
			$this->perfil = $perfil;
			$this->clave = $clave;
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
            usuarios.id_perfil 
            FROM usuarios");
            
            $query->execute();

            $array = $query->fetchAll(PDO::FETCH_OBJ);
            $arrayUsuarios = [];

            foreach($array as $item)
            {
                $aux = new Usuario($item->id,$item->nombre,$item->apellido,$item->correo,$item->foto,$item->id_perfil,$item->clave);
                array_push($arrayUsuarios,$aux);
            }

            return $arrayUsuarios;
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

                return $newResponse->withHeader('Content-Type', 'application/json');
            }
            
            $response->withStatus(403);
            return $newResponse->withHeader('Content-Type', 'application/json');

        }


		public function AltaUsuario(Request $request, Response $response, array $args) : Response
        {
            $params = $request->getParsedBody();
            $json = json_decode($params["usuario"]);
            $foto = $request->getUploadedFiles()["foto"];


            $retornoUsuario = new stdClass();
            $retornoUsuario->exito = false;
            $retornoUsuario->mensaje = "Error al agregar.";
            $retornoUsuario->status = 418;
            
            
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();

            foreach(self::TraerUsuarios() as $item){
                $ultimoId = $item->id;
            }

            $ultimoId += 1;


            $newResponse = new Response();

				$usuario = new Usuario(0,$json->nombre,$json->apellido,$json->correo,NULL,$json->perfil,$json->clave);

                if($foto != NULL)
                {
                    $pathDestino = "../fotosBD/" . $foto->getClientFilename();
                    $flag = false;
                
                    $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
                    $nombreArchivo = $usuario->correo . "_". $ultimoId . "." . $tipoDeArchivo;
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
                                $retornoUsuario->exito = $retorno->exito;
                                $retornoUsuario->mensaje = "Agregado con exito.";
                                $retornoUsuario->status = 200;

                                $newResponse->getBody()->write(json_encode($retornoUsuario));
                            }else{
                                $retornoUsuario->mensaje = $retorno->mensaje;
                                $newResponse->getBody()->write(json_encode($retornoUsuario));
                            }
                    }
                }
           
            return $newResponse;
        }

		public function AgregarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("INSERT INTO usuarios (nombre, apellido, correo, foto, id_perfil, clave) VALUES (:nombre, :apellido, :correo, :foto, :id_perfil, :clave)");

            $query->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $query->bindValue(':correo',$this->correo, PDO::PARAM_STR);
            $query->bindValue(':foto',$this->foto, PDO::PARAM_STR);
            $query->bindValue(':id_perfil',$this->perfil, PDO::PARAM_INT);
            $query->bindValue(':clave',$this->clave, PDO::PARAM_STR);

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



        public function ModificarUsuario(Request $request, Response $response, array $args) : Response
        {
    
                $obj = json_decode($args["usuario_json"]);

                $this->nombre = $obj->nombre;
                $this->apellido = $obj->apellido;
                $this->correo = $obj->correo;
                $this->foto = $obj->foto;
                $this->clave = $obj->clave;
                $this->id_perfil = $obj->id_perfil;
                $this->id = $obj->id;

                $usuarioPrevio = Usuario::TraeUnUsuario($obj->id);
                
                if($usuarioPrevio[0]->foto != NULL && isset($obj->foto))
                {           
                    $extension = explode(".",$usuarioPrevio[0]->foto);
                    $extension = array_reverse($extension);

                    $this->foto = "../src/fotos/".$this->foto;
                    rename($usuarioPrevio[0]->foto,$this->foto);            
                }

                $mensajeJSON = $this->ModificarUno();
                $newResponse = $response->withStatus(200, "OK");
                $newResponse->getBody()->write($mensajeJSON);
              
                return $newResponse->withHeader('Content-Type', 'application/json');
        }



        public function ModificarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("UPDATE usuarios
                                                    SET nombre = :nombre, apellido = :apellido, correo = :correo, foto = :foto, id_perfil = :id_perfil, clave = :clave 
                                                    WHERE id = :id");

            $query->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $query->bindValue(':correo',$this->correo, PDO::PARAM_STR);
            $query->bindValue(':foto',$this->foto, PDO::PARAM_STR);
            $query->bindValue(':id_perfil',$this->id_perfil, PDO::PARAM_INT);
            $query->bindValue(':clave',$this->clave, PDO::PARAM_STR);
            $query->bindValue(':id',$this->id, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo modificar el usuario";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se modifico el usuario con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }


        public function EliminarUsuario(Request $request, Response $response, array $args) : Response{

            $id = $args['id'];
            

            $respuesta = new stdClass();
            $respuesta->mensaje = "No se borro el Usuario.";
            $respuesta->status = 418;
            $respuesta->exito = false;

            $usuarioAEliminar = Usuario::TraeUnUsuario($id);
          
            $retornoBorrado = json_decode(Usuario::EliminarUnUsuario($id));

            if($retornoBorrado->exito){
                unlink($usuarioAEliminar[0]->foto);   

                $respuesta->exito = $retornoBorrado->exito;
                $respuesta->mensaje = "Se elimino correctamente.";
                $respuesta->status = 200;

                $newResponse = $response->withStatus(200);
            }else{
                $respuesta->mensaje = "Error al eliminar.";
                $newResponse = $response->withStatus(418);
            }

            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }

        public static function EliminarUnUsuario($id)
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");

            $query->bindValue(':id',$id, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo eliminar el Usuario";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se elimino el Usuario con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
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
            $retorno->Usuario = NULL;
            $retorno->status = 403;

            $params = $request->getParsedBody();

            $correo = $params["correo"];
            $passw = $params["clave"];

            $json = new stdClass();
            $json->correo = $correo;
            $json->clave = $passw;

            $usuario = Usuario::TraerUnoCorreoClave(json_encode($json));

            if($usuario != NULL){

                $retorno->Usuario = json_encode($usuario);
                $retorno->status = 200;
                $retorno->exito = true;

                $newResponse = $response->withStatus(200);
            }else{
                $retorno->Usuario = "No existe el Usuario";
                $newResponse = $response->withStatus(403);
            }

            $newResponse->getBody()->write(json_encode($retorno));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }
	}
?>