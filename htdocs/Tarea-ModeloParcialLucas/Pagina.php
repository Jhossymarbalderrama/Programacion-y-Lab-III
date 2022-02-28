<?php
if(isset($_POST["OPCION"]))
{
    $opcion = $_POST["OPCION"];
    if(isset($_POST["CORREO"]))
    {$correo = $_POST["CORREO"];}
    if(isset( $_POST["CLAVE"]))
    {$clave = $_POST["CLAVE"];}
    if($opcion=="LOGIN")
    {
        try{
            $conStr = 'mysql:host = localhost; dbname = usuarios_test';
            $pdo = new PDO($conStr, "root", "");
            $sentencia = $pdo->prepare('SELECT * FROM usuarios_test.usuarios WHERE CORREO = :correo AND CLAVE = :clave');
            $sentencia->execute(array(':correo' => $correo,':clave'=>$clave));
            $arrayUsuarios = $sentencia->fetchAll();
            if(sizeof($arrayUsuarios)==0){echo "No se encontro a nadie con ese correo y contraseña.";}
            else
            {
                foreach($arrayUsuarios as $miUsuario)
                {
                    $sentenciaPerfil = $pdo->prepare('SELECT * FROM usuarios_test.perfil WHERE PERFILES = :perfiles');
                    $sentenciaPerfil->execute(array(':perfiles' => $miUsuario[4]));
                    $perfil=$sentenciaPerfil->fetchAll();
                    echo $miUsuario[0]." ".$miUsuario[1]." ".$miUsuario[2]." ".$miUsuario[3]." ".$perfil[0]["DESCRIPCION"]."<br>";
                }
            }
        }
        catch(PDOException $e)
        {echo "Error: Usario no encontrado".$e->getMessage()."<br/>";}
    }else if($opcion=="MOSTRAR")
    {
        try
        {
            $conStr = 'mysql:host = localhost; dbname = usuarios_test';
            $pdo = new PDO($conStr, "root", "");
            $sentencia = $pdo->prepare('SELECT * FROM usuarios_test.usuarios');
            $sentencia->execute();
            $arrayUsuarios = $sentencia->fetchAll();
            if(sizeof($arrayUsuarios)==0){echo "No se encontro a nadie con ese correo y contraseña.";}
            else
            {
                foreach($arrayUsuarios as $miUsuario)
                {
                    $sentenciaPerfil = $pdo->prepare('SELECT * FROM usuarios_test.perfil WHERE PERFILES = :perfiles');
                    $sentenciaPerfil->execute(array(':perfiles' => $miUsuario[4]));
                    $perfil=$sentenciaPerfil->fetchAll();
                    echo $miUsuario[0]." ".$miUsuario[1]." ".$miUsuario[2]." ".$miUsuario[3]." ".$perfil[0]["DESCRIPCION"]."<br>";
                }
            }
        }
        catch(PDOException $e)
        {echo "Error al conectarse con el servidor: ".$e->getMessage()."<br/>";}
    }
}
?>