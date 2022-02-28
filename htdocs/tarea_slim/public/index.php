
<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Factory\AppFactory;
    use \Slim\Routing\RouteCollectorProxy;

    require_once "../vendor/autoload.php";

    $app = AppFactory::create();

    require_once "../src/poo/usuarios.php";

    $app->get('/Usuario/', Usuario::class . ':ListadoUsuarios');//ANDA


    $app->group('/Usuario', function (RouteCollectorProxy $grupo) {   
    
        //LISTA UNO O TODOS LOS USUARIOS
        //$grupo->get('/', Usuario::class . ':ListadoUsuarios');//ANDA
        $grupo->get('/{id}', \Usuario::class . ':TraerUno');//ANDA

        //ABM
        $grupo->post('/', \Usuario::class . ':AltaUsuario');//ANDA
        $grupo->put('/{usuario_json}', \Usuario::class . ':ModificarUsuario');//ANDA (con foto pasado por el json mediante PUT)
        $grupo->delete('/{id}', \Usuario::class . ':EliminarUsuario');//ANDA

        //LOGIN
        $grupo->post('/login',\Usuario::class . ':VerificarUsuario');//HACER
    
    });

    $app->run();
?>