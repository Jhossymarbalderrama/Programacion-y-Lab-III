<?php
class AccesoDatos
{
    private static $_objetoAccesoDatos;
    private $_objetoPDO;
 
    private function __construct()
    {
        try {
 
            $usuario='root';
            $clave='';

            /* $user = "id17685115_root";
            $pass = "R2KY]4D}W/@oS8yn";
            $baseDatos = "id17685115_usuarios_test";
            $host = "localhost"; */

            $this->_objetoPDO = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', $usuario, $clave);
 
        } catch (PDOException $e) {
 
            print "Error!!!<br/>" . $e->getMessage();
 
            die();
        }
    }
 
    public function RetornarConsulta($sql)
    {
        return $this->_objetoPDO->prepare($sql);
    }
 
    public static function DameUnObjetoAcceso()//singleton
    {
        if (!isset(self::$_objetoAccesoDatos)) {       
            self::$_objetoAccesoDatos = new AccesoDatos(); 
        }
 
        return self::$_objetoAccesoDatos;        
    }
 
    // Evita que el objeto se pueda clonar
    public function __clone()
    {
        trigger_error('La clonaci&oacute;n de este objeto no est&aacute; permitida!!!', E_USER_ERROR);
    }
}
