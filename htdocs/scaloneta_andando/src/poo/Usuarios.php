<?php
    require_once('AccesoDatos.php');

use Mpdf\Mpdf;
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

        /* public function __construct($id = 0, $nombre = "", $apellido = "", $correo = "", $perfil = "", $clave = "", $foto = NULL) */
        public function __construct($id = 0, $correo = "", $clave = "", $nombre = "", $apellido = "",$perfil = "", $foto = NULL)
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
                /* $aux = new Usuario($item->id,$item->nombre,$item->apellido,$item->correo,$item->perfil,$item->clave,$item->foto); */
                $aux = new Usuario($item->id, $item->correo,$item->clave,$item->nombre,$item->apellido,$item->perfil,$item->foto);
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
            $usuario = new Usuario(0,$json->correo,$json->clave,$json->nombre,$json->apellido,$json->perfil,NULL);

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
                    $usuario->foto = "./fotos/" . $nombreArchivo;
                    /* $usuario->foto = $pathDestino; */
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
                            $rtaUsuario->status = 418;
                            $newResponse->getBody()->write(json_encode($rtaUsuario));
                        }
                }
            }
            return $newResponse;
        }

        public function AgregarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
        
            $query = $accesoDatos->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, perfil, foto) VALUES (:correo, :clave, :nombre, :apellido, :perfil, :foto)");

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


        public function VerificarUsuario(Request $request, Response $response, array $args): Response{

            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->usuario = NULL;
            $retorno->status = 403;
            $newResponse = new Response();

            $params = $request->getParsedBody();

            $user = json_decode($params['user']);
            
            $json = new stdClass();
            $json->correo = $user->correo;
            $json->clave = $user->clave; 

            $usuario = Usuario::TraerUnoCorreoClave(json_encode($json));

            if($usuario != NULL){


                $usuarioSinClave = new stdClass();
                $usuarioSinClave->id=$usuario[0]->id;
                $usuarioSinClave->correo = $usuario[0]->correo;
                $usuarioSinClave->nombre = $usuario[0]->nombre;
                $usuarioSinClave->apellido = $usuario[0]->apellido;
                $usuarioSinClave->perfil = $usuario[0]->perfil;
                $usuarioSinClave->foto =$usuario[0]->foto;

                $retorno->usuario = json_encode($usuarioSinClave);
                $retorno->status = 200;
                $retorno->exito = true;

                $newResponse = $response->withStatus(200);
            }
            
            $newResponse->getBody()->write(json_encode($retorno));

            return $newResponse->withHeader('Content-Type' , 'application/json');
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

        public function EliminarUsuarioPorID(Request $request, Response $response, array $args) : Response
        {            
            $param = $request->getParsedBody();
           /*  $json = $param['id_usuario']; */
           $json = json_decode($param["usuario"]);
            
            $retorno = new stdClass();
            $retorno->exito = false;           
            $retorno->mensaje = "No se pudo Eliminar el Usuario de la BD";
            $retorno->status = 418;
            
            $response = new Response();

            $Seborro = Usuario::EliminarUsuario($json->id_usuario);
            $aux = json_decode($Seborro);

            if($aux->exito == true){
                $retorno->exito = true;
                $retorno->mensaje = "El Usuario con id ". $json->id_usuario ." Se elimino de la base de datos";
                $retorno->status = 200;
                $newResponse = $response->withStatus(200);
            }else{
                $newResponse = $response->withStatus(418);
            }

            $newResponse->getBody()->write(json_encode($retorno)); 

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }

        public static function EliminarUsuario($id)
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

        public function ModificarUsuario(Request $request, Response $response, array $args) : Response
        {
            $param = $request->getParsedBody();
            $json = json_decode($param['usuario']);
            
            if(isset($request->getUploadedFiles()['foto']))
            {
                $foto = $request->getUploadedFiles()['foto'];
            }else{
                $foto = NULL;
            }

            $newResponse = new Response();

            $rtaUsuario = new stdClass();
            $rtaUsuario->exito = false;
            $rtaUsuario->mensaje = "No se pudo Modificar el Usuario";
            $rtaUsuario->status = 418;


            $usuarioModificar = new Usuario($json->id_usuario,$json->correo,$json->clave,$json->nombre,$json->apellido,$json->perfil,NULL);

            if($foto != NULL || isset($foto))
            {

                $elUsuario = Usuario::TraeUnUsuario( $json->id_usuario);                        

                $pathDestino = "../fotosBD/" . $foto->getClientFilename();
                $flag = false;
            
                $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
                $nombreArchivo = $json->correo . "_". $json->id_usuario . "_modificacion." . $tipoDeArchivo;
                $pathDestino = "../src/fotos/" . $nombreArchivo;

                if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
                {
                    
                    $foto->moveTo($pathDestino);

                    $SoloNombreFoto = explode('/',$elUsuario[0]->foto);
                    $SoloNombreFoto = array_reverse($SoloNombreFoto);
                    $dir = __DIR__;
                    $dir = substr($dir, 0 , -4);
                    
                    $fotoViejaAEliminar = $SoloNombreFoto[0];
                    unlink($dir."/fotos/". $fotoViejaAEliminar);

                    $usuarioModificar->foto = "./fotos/" . $nombreArchivo;                    
                    
                }                           
            }

            $aux = $usuarioModificar->ModificarUsuarioBD();
    
            if(json_decode($aux)->exito == true)
            {
                $rtaUsuario->exito = true;
                $rtaUsuario->mensaje = "Se Modifico al Usuario";
                $rtaUsuario->status = 200;
            }


            $newResponse->getBody()->write(json_encode($rtaUsuario));
            return $newResponse->withHeader('Content-Type' , 'application/json');
        }

        public function ModificarUsuarioBD()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            if($this->foto != NULL)
            {
                $query = $accesoDatos->RetornarConsulta("UPDATE usuarios
                                                            SET correo = :correo, clave = :clave, nombre = :nombre, apellido = :apellido, perfil = :perfil, foto = :foto 
                                                            WHERE id = :id");
            }else{                 
                $query = $accesoDatos->RetornarConsulta("UPDATE usuarios
                                                            SET correo = :correo, clave = :clave, nombre = :nombre, apellido = :apellido, perfil = :perfil 
                                                            WHERE id = :id");
            }
           
            $query->bindValue(':correo',$this->correo, PDO::PARAM_STR);
            $query->bindValue(':clave',$this->clave, PDO::PARAM_STR);
            $query->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $query->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);
            if($this->foto != NULL)
            {
                $query->bindValue(':foto',$this->foto, PDO::PARAM_STR); 
            }          

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


        public function ListUsuariosHTML(Request $request, Response $response, array $args) : Response
        {
            $responseMW = new Response();
            $arrayDeUsuarios = Usuario::TraerUsuarios();

            if(isset($arrayDeUsuarios)){

                $TableHTML = "<table align='center'>                
                                <tr>
                                    <td>
                                        |
                                    </td>
                                    <td>
                                    <b>ID</b> -
                                    </td>
                                    <td>
                                        <b>NOMBRE</b> -
                                    </td>
                                    <td>
                                        <b>APELLIDO</b> -
                                    </td>
                                    <td>
                                        <b>CORREO</b> -
                                    </td>
                                    <td>
                                        <b>PERFIL</b> - 
                                    </td>
                                    <td>
                                        <b>FOTO</b>
                                    </td>
                                    <td>
                                        |
                                    </td>
                                </tr>";

                foreach($arrayDeUsuarios as $item){
                    unset($item->clave);  
                    
                    $TableHTML .= "<tr>
                                    <td>
                                        |
                                    </td>
                                    <td>
                                        $item->id
                                    </td>
                                    <td>
                                        $item->nombre
                                    </td>
                                    <td>
                                        $item->apellido
                                    </td>
                                    <td>
                                        $item->correo
                                    </td>
                                    <td>
                                        $item->perfil
                                    </td>
                                    <td>
                                        $item->foto
                                    </td>
                                    <td>
                                        |
                                    </td>
                                </tr>";
                }

                $TableHTML .= "</table>";

                /* echo $TableHTML; */
                $responseMW->getBody()->write(json_encode($TableHTML));
                    
            }

            return $responseMW;
        }
       

        public static function PDFSoloPropietarios(Request $request, Response $response, array $args) : Response
        {
            $responseMW = new Response();        
            $json = $request->getParsedBody();
            $params = json_decode($json["usuario"]); 
            

            /**           
             * Retorna un JSON (éxito: true/false; mensaje: string; status: 200/418)
             */

            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->mensaje = "El Usuario no es un Propietario";
            $retorno->status = 418;

            if(strtolower($params->perfil) == 'propietario')
            {
                header('content-type:application/pdf');

                /**Listo Los Usuarios que tengo */
                $mpdf = new Mpdf(['orientation' => 'P', 
                'pagenumPrefix' => 'Página nro. ',
                'pagenumSuffix' => ' - ',
                'nbpgPrefix' => ' de ',
                'nbpgSuffix' => ' páginas']);//P-> vertical; L-> horizontal
    
                $mpdf->SetHeader('Balderrama Jhossymar ||{PAGENO}{nbpg}');
                //alineado izquierda | centro | alineado derecha
                $mpdf->setFooter(__DIR__ . '||{PAGENO}');
              
              
                $arrayUsuarios = Usuario::TraerUsuarios();
            
                
                $grilla = '<table class="table" border="1" align="center">
                            <thead>
                                <tr>
                                    <th>  DNI         </th>
                                    <th>  NOMBRE     </th>
                                    <th>  APELLIDO       </th>
                                    <th>  CORREO       </th>
                                    <th>  PERFIL       </th>
                                    <th>  FOTO       </th>
                                </tr> 
                            </thead>';   	
                
                foreach ($arrayUsuarios as $prod){
                    $id = $prod->id;
                    $grilla .= "<tr>
                                    <td>".$prod->id."</td>
                                    <td>".$prod->nombre."</td>
                                    <td>".$prod->apellido."</td>
                                    <td>".$prod->correo."</td>
                                    <td>".$prod->perfil."</td>
                                    
                                    <td><img src='"."../src".$prod->foto."' width='50px' height='50px'/></td>                        
                                </tr>";
                }
                
                /**
                 * $tabla.= "<td>" .'<img src="'."../src".$listado[$i]->foto.'" width="50" height="50"'. "</td>";
                 * 
                 */
                /**Fotos */
                /* <td>".$prod->foto."</td> */
                

                $grilla .= '</table>';
                
                $mpdf->WriteHTML("<h3>Listado de Usuarios</h3>");
                $mpdf->WriteHTML("<br>");
                $mpdf->WriteHTML($grilla);
                
                
                $mpdf->Output('Lista_Empleados.pdf', 'I');
    
    
                $responseMW->getBody()->write($mpdf);
            }else{
                $responseMW->getBody()->write(json_encode($retorno));
            }
                    
            return $responseMW->withHeader('Content-Type' , 'application/json');;
        }
    }
?>