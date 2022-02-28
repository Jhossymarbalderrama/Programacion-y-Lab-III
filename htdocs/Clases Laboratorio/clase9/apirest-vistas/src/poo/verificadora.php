<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__ . "/ivalidable.php";
require_once __DIR__ . "/accesoDatos.php";


class Verificadora implements IValidable{
  
    public function ArmarRespuesta(Request $request, RequestHandler $handler) : ResponseMW
    {

        $obj_datos = new stdClass();
        $obj_datos->exito = FALSE;
        $obj_datos->mensaje = "";
        $obj_datos->datos = NULL;

        $response = $handler->handle($request);
        $retorno = json_decode($response->getBody());

        if( ! is_array($retorno) && $retorno && property_exists($retorno, "exito")) {//validaciones

            $obj_datos->datos = $retorno->exito ? json_decode($response->getBody()) : NULL;
            $obj_datos->exito = $retorno->exito;
            $obj_datos->mensaje = $retorno->mensaje;
            $status = $retorno->status;

        }
        else {//traerUno / traerTodos

            $obj_datos->datos = json_decode($response->getBody());
            $obj_datos->exito = $obj_datos->datos !== FALSE ? TRUE : FALSE;
            $obj_datos->mensaje = $obj_datos->exito ? "" : "No hay registros que coincidan con su búsqueda.";
            $status = $obj_datos->exito ? 200 : 500;
        }

        $response = new ResponseMW($status);

        $response->getBody()->write(json_encode($obj_datos));

        return $response->withHeader('Content-Type', 'application/json');
    }

    //IValidable
    public function ValidarParametrosCDAgregar(Request $request, RequestHandler $handler) : ResponseMW {
    
        $datos = new stdclass();
        $datos->exito = TRUE;
        $datos->status = 200;
        $datos->mensaje = "";

        $arrayDeParametros = $request->getParsedBody();

        if ( ! isset($arrayDeParametros["titulo"])) {
        
            $datos->mensaje .= "Falta parámetro título!!! ";      
        }
        else if($arrayDeParametros["titulo"] == ""){

            $datos->mensaje .= "Atributo título vacío!!! ";
        }

        if ( ! isset($arrayDeParametros["cantante"])) {
        
            $datos->mensaje .= "Falta parámetro cantante!!! ";       
        }
        else if($arrayDeParametros["cantante"] == ""){

            $datos->mensaje .= "Atributo cantante vacío!!! ";
        }

        if ( ! isset($arrayDeParametros["anio"])) {
        
            $datos->mensaje .= "Falta parámetro año!!! ";       
        }
        else if($arrayDeParametros["anio"] == ""){

            $datos->mensaje .= "Atributo año vacío!!! ";
        }

        if ($datos->mensaje !== "") 
        {
            $datos->exito = FALSE;
            $datos->status = 403;
        }
        else
        {
            $response = $handler->handle($request);
            $datos = json_decode($response->getBody());
        }           
    
        $response = new ResponseMW();
    
        $response->getBody()->write(json_encode($datos));
      
        return $response->withHeader('Content-Type', 'application/json');
    } 

    public function ValidarParametrosCDModificar(Request $request, RequestHandler $handler) : ResponseMW {
    
        $datos = new stdclass();
        $datos->exito = TRUE;
        $datos->status = 200;
        $datos->mensaje = "";

        $contentType = $request->getHeaderLine('Content-Type');

        if (strstr($contentType, 'application/json')) {

            $obj = json_decode(file_get_contents('php://input'), false);//true->array; false->object;

            if (json_last_error() === JSON_ERROR_NONE) {              
                
                if (! property_exists($obj, "id")) 
                {
                    $datos->mensaje .= "Falta atibuto ID!!!";
                }
                else
                {
                    if($obj->id == ""){
                        $datos->mensaje .= "Atibuto ID vacío!!!";
                    }
                }
    
                if (! property_exists($obj, "titulo")) 
                {
                    $datos->mensaje .= "Falta atibuto título!!!";
                }
                else
                {
                    if($obj->titulo == ""){
                        $datos->mensaje .= "Atibuto título vacío!!!";
                    }
                }
    
                if (! property_exists($obj, "cantante")) 
                {
                    $datos->mensaje .= "Falta atibuto cantante!!!";
                }
                else
                {
                    if($obj->cantante == ""){
                        $datos->mensaje .= "Atibuto cantante vacío!!!";
                    }
                }
    
                if (! property_exists($obj, "anio")) 
                {
                    $datos->mensaje .= "Falta atibuto año!!!";
                }
                else
                {
                    if($obj->anio == ""){
                        $datos->mensaje .= "Atibuto año vacío!!!";
                    }
                }

                if ($datos->mensaje !== "") 
                {
                    $datos->exito = FALSE;
                    $datos->status = 500;
                }
                else
                {
                    $_POST["cadenaJson"] = json_encode($obj);

                    $response = $handler->handle($request);
                    $datos = json_decode($response->getBody());
                    $datos->mensaje = "CD modificado.";
                }     

            }
            else{
                $datos->mensaje = "Falta parámetro JSON!!!";
                $datos->exito = FALSE;
                $datos->status = 500;
            }
        }
        else{
            $datos->mensaje = "El content-type debe ser 'application/json";
            $datos->status = 500;
        }
 
        $response = new ResponseMW();
    
        $response->getBody()->write(json_encode($datos));
      
        return $response->withHeader('Content-Type', 'application/json');
    } 

    public function ValidarParametrosCDBorrar(Request $request, RequestHandler $handler) : ResponseMW {
    
        $datos = new stdclass();
        $datos->exito = TRUE;
        $datos->status = 200;
        $datos->mensaje = "";

        $contentType = $request->getHeaderLine('Content-Type');

        if (strstr($contentType, 'application/json')) {

            $obj = json_decode(file_get_contents('php://input'), false);//true->array; false->object;

            if (json_last_error() === JSON_ERROR_NONE) {              
                
                if (! property_exists($obj, "id")) 
                {
                    $datos->mensaje .= "Falta atibuto ID!!!";
                }
                else
                {
                    if($obj->id == ""){
                        $datos->mensaje .= "Atibuto ID vacío!!!";
                    }
                }

                if ($datos->mensaje !== "") 
                {
                    $datos->status = 500;
                }
                else
                {
                    $_POST["cadenaJson"] = json_encode($obj);

                    $response = $handler->handle($request);
                    $datos = json_decode($response->getBody());
                }   

            }
            else{
                    $datos->mensaje = "Falta parámetro JSON!!!";
                    $datos->exito = FALSE;
                    $datos->status = 500;
                }
        }
        else{
            $datos->mensaje = "El content-type debe ser 'application/json";
            $datos->exito = FALSE;
            $datos->status = 500;
        }

        $response = new ResponseMW();
    
        $response->getBody()->write(json_encode($datos));
      
        return $response->withHeader('Content-Type', 'application/json');
    } 
}