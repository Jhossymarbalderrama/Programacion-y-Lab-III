<?php
class Usuario
{
    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $perfil;

    public function MostrarDatos()
    {
            return $this->id." - ".$this->correo." - ".$this->clave." - ".$this->nombre . " - ".$this->perfil;
    }
    
    public static function TraerTodosLosUser()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `usuarios`");
        
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);                                                

        return $consulta; 
    }
    
    public function InsertUser()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `usuarios`(`CORREO`, `CLAVE`, `NOMBRE`, `PERFIL`) VALUES(:correo,:clave,:nombre,:perfil)");
        
        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);

        $consulta->execute();   

    }
    
    public static function ModificarUser($id, $correo, $clave, $nombre , $perfil)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, 
                                                        nombre = :nombre, perfil = :perfil WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $perfil, PDO::PARAM_STR);

        return $consulta->execute();

    }

    public static function EliminarUser($cd)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
        
        $consulta->bindValue(':id', $cd->id, PDO::PARAM_INT);

        return $consulta->execute();

    }
    
}