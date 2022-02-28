<?php

/* require __DIR__ . '/../src/app/app.php'; */


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require '../vendor/autoload.php';


$app = AppFactory::create();

/*
    metodo->get("raizDeLaAplicacion (/) ", FuncionColdback(objetoConTodasLaPeticion, El retornoDelNavegador, ArrayDeArgumentosOParametros))
*/
$app->get('/', function (Request $request, Response $response, array $args) : Response {  

    /**Todos los metodos que se necesiten estan en el Atributo $response */
    /**Y  toda la informacion sobre la peticion esta en el $request*/
    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework 4");
    return $response;
});

/**APP->VERBO(RutaDondeVaIrlaApp/SegundaRuta/TerceraRuta) */
$app->post('/', function (Request $request, Response $response, array $args) : Response { 

    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework 4");
    return $response;
});

//CORRE LA APLICACIÓN.
$app->run();