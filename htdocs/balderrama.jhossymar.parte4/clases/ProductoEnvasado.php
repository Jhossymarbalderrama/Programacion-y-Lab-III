<?php
    require_once("./clases/AccesoDatos.php");
    require_once("Producto.php");
    require_once("IParte1.php");
    require_once("IParte2.php");
    require_once("IParte3.php");

    class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3
    {
        public $id;
        public $codigoBarra;
        public $precio;
        public $pathFoto;

        public function __construct($id = 0, $codigoBarra = 0,$precio = 0,$pathFoto = null,$nombre,$origen){
          parent::__construct($nombre,$origen);
          $this->id = $id;
          $this->codigoBarra = $codigoBarra;
          $this->precio = $precio;
          $this->pathFoto = $pathFoto;
        }

        public function ToJSON()
        {
            $obj = new stdClass();
            $obj->nombre = $this->nombre;
            $obj->origen = $this->origen;
            $obj->id = $this->id;
            $obj->codigoBarra = $this->codigoBarra;
            $obj->precio = $this->precio;
            $obj->pathFoto = $this->pathFoto;
            
            return json_encode($obj);
        }

        function Agregar()
        {   
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();
            
            $sql = "INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) VALUES (:codigo_barra, :nombre, :origen, :precio, :foto)";

            $query = $accesoDatos->RetornarConsulta($sql);
            $query->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $query->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $query->bindValue(':precio', $this->precio, PDO::PARAM_STR);
            $query->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
                    
            try{
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $e){
                echo "ERROR!!! ".$e->getMessage();
                return false;
            }
        }

        public static function Traer()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("SELECT productos.id, productos.codigo_barra, productos.nombre,productos.origen,productos.precio,productos.foto AS pathFoto FROM productos");
            
            try{
                $query->execute();
                $datos = $query->fetchAll(PDO::FETCH_OBJ);
                $datosProductos = [];

                foreach ($datos as $item) {
                    $producto = new ProductoEnvasado($item->id,$item->codigo_barra,$item->precio,$item->pathFoto,$item->nombre,$item->origen);
                    array_push($datosProductos,$producto);
                }
                return $datosProductos;            
            }catch(PDOException $e){
                echo "ERROR!!! ".$e->getMessage();
            }
        }

        public static function Eliminar($id)
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("DELETE FROM productos WHERE id = :id");
            $query->bindValue(":id", $id,PDO::PARAM_INT);

            try
            {   
                $query->execute();

                if($query->rowCount() > 0)
                {
                    return true;
                }else
                {
                    return false;
                }

            }catch(PDOException $e)
            {
                echo "ERROR. ".$e->getMessage();
                return false;
            }
        }

        public function Modificar()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigo_barra,  precio = :precio, foto = :foto WHERE id = :id");
        
            $query->bindValue(":id", $this->id, PDO::PARAM_INT);
            $query->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $query->bindValue(":origen", $this->origen, PDO::PARAM_STR);
            $query->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
            $query->bindValue(":precio", $this->precio, PDO::PARAM_INT);
            $query->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);


            try
            {
                $query->execute();

                if($query->rowCount() > 0)
                {
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $e)
            {
                echo "ERROR. " . $e->getMessage();
                return false;
            }
        }

        public function Exite($array_ProductoEnvasado)
        {
            $rta = false;
            foreach ($array_ProductoEnvasado as $item) {
                if($item->nombre == $this->nombre && $item->origen == $this->origen)
                {
                    $rta = true;
                    break;
                }
            }
            return $rta;
        }
        
        public function GuardarEnArchivo()
        {
            $path = "./archivos/productos_envasados_borrados.txt";
            
            $archivo = fopen($path, "a");
            
            if($this->pathFoto != null)
            {
                $extension = pathinfo($this->pathFoto,PATHINFO_EXTENSION);
                $date = date("Gis");
                $stringDatos = $this->id.$this->nombre."borrado".$date.".".$extension;
                $pathFotoBorrada = "./productosBorrados/".$stringDatos;            
                rename($this->pathFoto, $pathFotoBorrada);
                
            }

            $datos = "{$this->id} - {$this->nombre} - {$this->origen} - {$this->codigoBarra} - {$this->precio} - {$pathFotoBorrada}" . PHP_EOL;

            $archivo = fwrite($archivo, $datos);
        }

        public static function ProductoEnvasado()
        {
            $path = "./archivos/productos_eliminados.json";
            $archivo = fopen($path,"r");

            $obj_json = fread($archivo,filesize($path));

            return $obj_json;
        }

        public static function MostrarModificados()
        {   
            $path = "./productosModificados/";
            $directorio = opendir($path);
         
            $retorno = array();

            while($elemento = readdir($directorio))
            {
                if($elemento != "." && $elemento != "..")
                {
                    array_push($retorno,$elemento);                      
                }
            }
            return $retorno;
        }
    }
?>