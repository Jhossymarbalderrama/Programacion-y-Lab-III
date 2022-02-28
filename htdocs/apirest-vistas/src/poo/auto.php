<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Auto {

    public function ObtenerAutosJson(Request $request, Response $response, array $args) : Response {

        $autos = $this->ObtenerAutos();

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($autos));
    
        return $newResponse->withHeader('Content-Type', 'application/json');

    }

    private function ObtenerAutos() : string {

        $path = __DIR__ . "/../archivos/autos.json";

        $a = fopen($path ,"r");

        $autos_string = fread($a, filesize($path));

        fclose($a);

        return $autos_string;
    }

}