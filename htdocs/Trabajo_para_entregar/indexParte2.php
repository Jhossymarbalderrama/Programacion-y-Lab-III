<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajo para Entregar P2</title>
</head>
<body>
    <table align="center">
        <tr>
            <td>
                <h3>Conneccion con Base de Datos - Parte 2</h3>
                <hr>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                    require_once("AccesoDatos.php");
                    require_once("usuarios.php");

                    $opcion = isset($_POST['opcion']) ? $_POST['opcion'] : NULL; 
                    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
                    $obj = isset($_POST['json']) ? $_POST['json']:NULL;


                    switch ($opcion) {
                        case 'login':
                             try{
                                $obj = json_decode($_POST['json_login']);

                                $correo = $obj->correo;
                                $clave = $obj->clave;
                        
                                $aux = Usuario::Login($correo, $clave);
                        
                                if(isset($aux)){
                                    
                                    foreach ($aux as $usuario) {                                        
                                        print_r($usuario->MostrarDatos());                                       
                                    }
                                }
                                else
                                {
                                    echo "Usuario no Coincide";
                                }                        
                            }catch(PDOException $e){
                                echo "Error!!!\n" . $e->getMessage();
                            } 
                            break;
                        case 'mostrar':
                            try{
                                $usuarios = Usuario::TraerTodosLosUsuarios();

                                foreach ($usuarios as $usuario) {                                
                                    print_r("<br>" . $usuario->MostrarDatos());                                    
                                }
                                    
                            }catch(PDOException $e){
                                echo "Error!!!\n" . $e->getMessage();
                            }
                            
                            break;
                        case "alta":
                            $obj = json_decode($_POST['json']);
                            $correo = $obj->correo;
                            $clave = $obj->clave;
                            $nombre = $obj->nombre;
                            $perfil = $obj->perfil;
                            
                            Usuario::InsertarElUsuario($correo,$clave,$nombre,$perfil);
                            break;
                        case "modificar":
                            $obj = json_decode($_POST['json']);
                            $correo = $obj->correo;
                            $clave = $obj->clave;
                            $nombre = $obj->nombre;
                            $perfil = $obj->perfil;

                            Usuario::ModificarUsuario($id,$correo,$clave,$nombre,$perfil);
                            echo "Se modifico un Usuario";
                            break;
                        case "baja":
                            Usuario::EliminarUsuario($id);

                            echo "Se dio de baja al Usuario";
                            break;
                    }
                ?>
            </td>
        </tr>
    </table>    
</body>
</html>
