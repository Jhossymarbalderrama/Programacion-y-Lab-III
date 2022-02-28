<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajo para Entregar P1</title>
</head>
<body>
    <table align="center">
        <tr>
            <td>
                <h3>Conneccion con Base de Datos - Parte 1</h3>
                <hr>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                    $opcion = isset($_POST['opcion']) ? $_POST['opcion'] : NULL; 
                    $correo = isset($_POST['correo']) ? $_POST['correo'] : NULL; 
                    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;  


                    /* $user = "id17685115_root";
                    $pass = "R2KY]4D}W/@oS8yn";
                    $baseDatos = "id17685115_usuarios_test";
                    $host = "localhost"; */
                    

                    switch ($opcion) {
                        case 'login':
                             try{

                                /* $conection = @mysqli_connect($host, $user, $pass, $baseDatos); */
                                $conection = @mysqli_connect('localhost', $user, $pass, 'usuarios_test');

                                $sql = "SELECT usuarios.nombre, perfiles.descripcion
                                        FROM `usuarios`
                                        JOIN `perfiles` ON usuarios.perfil = perfiles.id
                                        WHERE usuarios.correo = '$correo' && usuarios.clave = '$clave'";

                                $rs = $conection->query($sql);

                                while ($row = $rs->fetch_object())
                                { 
                                    $user_arr[] = $row;
                                }  

                                
                                if(isset($user_arr) == true){ 
                                    echo "<pre>";
                                    var_dump($user_arr); 
                                    echo "</pre>";
                                }else{
                                    echo "Usuario No Coincide";
                                }
                                
                                mysqli_close($conection);
                            }catch(PDOException $e){
                                echo "Error!!!\n" . $e->getMessage();
                            } 
                            break;
                        case 'mostrar':
                            try{
                                /* $conection = @mysqli_connect($host, $user, $pass, $baseDatos); */
                                $conection = @mysqli_connect('localhost', $user, $pass, 'usuarios_test');

                                $sql = "SELECT * FROM usuarios JOIN `perfiles` ON usuarios.perfil = perfiles.id";
                                
                                $respuesta = $conection->query($sql);

                                while ($row = $respuesta->fetch_object())
                                { 
                                    $user_arr[] = $row;
                                } 

                                echo "<pre>";
                                    var_dump($user_arr); 
                                echo "</pre>";
                                mysqli_close($conection);
                            }catch(PDOException $e){
                                echo "Error!!!\n" . $e->getMessage();
                            }
                            
                            break;
                        default:
                            # code...
                            break;
                    }
                ?>
            </td>
        </tr>
    </table>    
</body>
</html>
