<?php
// ProductoEnvasado.php. Crear, en ./clases, la clase ProductoEnvasado (hereda de producto) con atributos públicos (id, codigoBarra, precio y pathFoto), constructor (con todos sus parámetros opcionales), un método de instancia ToJSON(), que retornará los datos de la instancia (en una cadena con formato JSON)
require_once('./clases/Producto.php');
require_once('./clases/AccesoDatos.php');
require_once('IParte1.php');
require_once('IParte2.php');
require_once('IParte3.php');
class ProductoEnvasado extends Producto implements IParte1,IParte2,IParte3
{

    public $id;
    public $codigoBarra;
    public $precio;
    public $pathFoto;

    public function __construct($nombre='',$origen='',$id='',$codigoBarra='',$precio='',$pathFoto='')
    {
        parent::__construct($nombre,$origen);
        $this->id=$id;
        $this->codigoBarra=$codigoBarra;
        $this->precio=$precio;
        $this->pathFoto=$pathFoto;
    }

    //un método de instancia ToJSON(), que retornará los datos de la instancia (en una cadena con formato JSON).
    public function ToJSON()
    {
        $mensaje = json_decode(parent::ToJSON());
        $mensaje->id = $this->id;
        $mensaje->codigoBarra = $this->codigoBarra;
        $mensaje->precio = $this->precio;
        $mensaje->pathFoto = $this->pathFoto;

        return json_encode($mensaje);
    }



    // Agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla productos (id, codigo_barra, nombre, origen, precio, foto), de la base de datos productos_bd. Retorna true, si se pudo agregar, false, caso contrario.
    public function Agregar()
    {
        
        $retorno = false; 
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $consulta = $pdo->RetornarConsulta("INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) 
                                            VALUES (:codigo_barra, :nombre, :origen, :precio, :foto)");
            $consulta->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $retorno = true;
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $retorno;
    }

   
    public static function Traer(){
        $arrayProductos = array();
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $consulta = $pdo->RetornarConsulta("SELECT id,codigo_barra AS codigoBarra,nombre,origen,precio,foto AS pathFoto "
            . "FROM productos");
            $consulta->execute();
            while($obj = $consulta->fetch(PDO::FETCH_OBJ)){
                $productoAux = new ProductoEnvasado($obj->nombre, $obj->origen, $obj->id, $obj->codigoBarra, $obj->precio, $obj->pathFoto);
                array_push($arrayProductos, $productoAux);
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $arrayProductos;
    }


    public static function Eliminar($id)
    {
        $retorno = false;
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();//acceso a datos 
            $consulta = $pdo->RetornarConsulta("DELETE FROM productos WHERE id = :id");
           // $consulta->bindParam(":id", $id, PDO::PARAM_INT);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $retorno = true;
            }
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage() ."<br/>";
        }
        return $retorno;
    }

  

    public function Modificar()
    {
        $retorno = false;
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $consulta = $pdo->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigo_barra, precio = :precio, foto = :foto WHERE id = :id");
            $consulta->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);
            $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);

            $consulta->execute();
            if($consulta->rowCount() > 0){
                $retorno = true;
            }
        }
        catch(PDOException $e){
            echo "Eeror: " . $e->getMessage() ."<br/>";
        }
        return $retorno;
    }

    public function Existe($listado)
    {
        $retorno = false;
        foreach($listado as $item){
            if($item->nombre == $this->nombre && $item->origen == $this->origen){
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

//     GuardarEnArchivo: escribirá en un archivo de texto (./archivos/productos_envasados_borrados.txt) toda
// la información del producto envasado más la nueva ubicación de la foto. La foto se moverá al
// subdirectorio “./productosBorrados/”, con el nombre formado por el id punto nombre punto 'borrado'
// punto hora, minutos y segundos del borrado (Ejemplo: 688.tomate.borrado.105905.jpg).
    public function GuardarEnArchivo()
    {
        $retorno = false;
        $path = "./archivos/productos_envasados_borrados.txt";
        $infoFoto = pathinfo($this->pathFoto,PATHINFO_EXTENSION);
        $pathDestino = "./productosBorrados/" . $this->id.$this->nombre . ".borrado.". date('Gis') . "." . $infoFoto; 
        if (file_exists($path)) {
            $archivo = fopen($path, "w");
            if ($archivo) {
                $infoProducto ="{$this->id}-{$this->nombre}-{$this->origen}-{$this->codigoBarra}-{$this->precio}-{$pathDestino}" . PHP_EOL;
                
                if(fwrite($archivo, $infoProducto . "\r\n")){
                    rename("./productos/imagenes/".$this->pathFoto,$pathDestino);
                    //unlink($this->pathFoto);
                    //copy("./productos/imagenes/".$this->pathFoto, $pathDestino);//Cambia de nombre y mueve el archivo
                    $retorno = true;
                }
            }
            fclose($archivo);
        }
        return $retorno;
    }

    public static function MostrarBorradosJSON()
    {
        $path = "./archivos/productos_eliminados.json";
        $arrayProductos = array();
        if (file_exists($path)) {
            $archivoAbierto = fopen($path, "r");
            if ($archivoAbierto) {
                while (!feof($archivoAbierto))
                {
                    $lineaLeida = trim(fgets($archivoAbierto));
                    if ($lineaLeida > 0) {

                        array_push($arrayProductos, $lineaLeida);
                    }
                }
            }
            fclose($archivoAbierto);
        }
        return $arrayProductos;
    }
    
  
    public static function MostrarModificados()
    {
        $path= './productosModificados/';
        $directorio = opendir($path);
        $imagenes = array();
        while (($file = readdir($directorio))) {
            if($file !== '.' && $file !== ".."){
                array_push($imagenes, $file);
            }
        }
        return $imagenes;
    }
    

}
    

?>