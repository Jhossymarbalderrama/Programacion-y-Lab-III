<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Factory\AppFactory;
    use \Slim\Routing\RouteCollectorProxy;

    use Slim\Views\Twig;
    use Slim\Views\TwigMiddleware;

    require __DIR__ . '../../vendor/autoload.php';
    require_once("../src/poo/Usuarios.php");
    require_once("../src/poo/Autos.php");
    require_once("../src/poo/MW.php");

    $app = AppFactory::create();
    
    /* $app->addErrorMiddleware(true,true,true); */
    /* $app->setBasePath("/public/index.php"); */

    $twig = Twig::create('../src/views', ['cache' => false]);

    $app->add(TwigMiddleware::create($app, $twig));
    
     /**Usuarios *//**_______________________________________________________________________________________________________________________________________________________ */
   
        $app->post('/usuarios',\Usuario::class . ':AltaUsuario')->add(\MW::class . '::VerificacionExisteBD')->add(\MW::class . '::ValidacionParametrosVacios');

        $app->get('/',\Usuario::class . ':ListadoUsuarios');

    /**Autos *//**_______________________________________________________________________________________________________________________________________________________ */
        $app->post('/',\Auto::class . ':AltaAuto');

        $app->get('/autos',\Auto::class . ':ListadoAutos');

    /**Login *//**_______________________________________________________________________________________________________________________________________________________ */
    $app->post('/login',\Usuario::class . ':VerificarUsuario')->add(\MW::class . ':VerificarUsuarioBD')->add(\MW::class . '::ValidacionParametrosVacios');


    /**CARS  --- DELETE Y PUT */
    $app->group('/cars', function (RouteCollectorProxy $grupo){   
        $grupo->delete('/{id_auto}', \Auto::class . ':EliminarAutoPorID');
       
        $grupo->put('/{auto}', \Auto::class . ':ModificarAutoPorID');   
    });


    /**USERS  --- DELETE Y PUT */
    $app->group('/users', function (RouteCollectorProxy $grupo) {   
        $grupo->post('/delete', \Usuario::class . ':EliminarUsuarioPorID');     
        $grupo->post('/edit', \Usuario::class . ':ModificarUsuario');    
    });

    /**WTF Como pija se hace */
    $app->group('/tablas', function (RouteCollectorProxy $grupo) {       
        $grupo->get('/usuarios',\Usuario::class . ':ListUsuariosHTML');
        $grupo->post('/usuarios',\Usuario::class . '::PDFSoloPropietarios');
        $grupo->get('/autos',\Auto::class . '::ListAutosHTML');
    });

    /**BACKEND with FRONTEND */

    $app->get('/loginusuarios', function (Request $request, Response $response, array $args) : Response { 
        $view = Twig::fromRequest($request);
        return $view->render($response, 'login.html');
    });

    $app->get('/registro', function (Request $request, Response $response, array $args) : Response { 
        $view = Twig::fromRequest($request);
        return $view->render($response, 'registro.html');
    });

    $app->get('/principal', function (Request $request, Response $response, array $args) : Response { 
        $view = Twig::fromRequest($request);
        return $view->render($response, 'principal.php');
    });

    $app->run();
?>