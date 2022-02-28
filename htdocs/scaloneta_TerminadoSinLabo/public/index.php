<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Factory\AppFactory;
    use \Slim\Routing\RouteCollectorProxy;


    require __DIR__ . '../../vendor/autoload.php';
    require_once("../src/poo/Usuarios.php");
    require_once("../src/poo/Autos.php");
    require_once("../src/poo/mw.php");

    $app = AppFactory::create();
    /**USUARIOS*//**________________________________________________________________________________________________________________________________________ */        
        $app->post('/usuarios',\Usuario::class . ':AltaUsuario')->add(\MW::class . '::VerificacionExisteBD')->add(
            \MW::class . '::ValidacionParametrosVacios')->add(\MW::class . ':ValidarParametrosUsuario');        


        /* $app->get('/',Usuario::class . ':ListadoUsuarios'); */
        
        $app->get('/',Usuario::class . ':ListadoUsuarios')->add(\MW::class . ':AccedePropietarioB')->add(\MW::class . ':AccedeEncargadoB')
        ->add(\MW::class . ':AccedeEmpleadoB')->add(\MW::class . ':ChequearJWT');
    
     /**AUTOS*//**________________________________________________________________________________________________________________________________________ */

        $app->post('/',\Auto::class . ':AltaAuto')->add(\MW::class . ':VerificacionRangoPrecioYColor');    

        /**SIN PARTE 4 - A */
        /* $app->get('/autos',\Auto::class . ':ListadoAutos'); */

        /**PARTE 4 - A */
        $app->get('/autos',\Auto::class . ':ListadoAutos')->add(\MW::class . ':AccedePropietario')->add(\MW::class . ':AccedeEncargado')
        ->add(\MW::class . ':AccedeEmpleado')->add(\MW::class . ':ChequearJWT');

    /**LOGIN*//**________________________________________________________________________________________________________________________________________ */    

        $app->post('/login',\Usuario::class . ':VerificarUsuario')->add(\MW::class . ':VerificarUsuarioBD')->add(
            \MW::class . '::ValidacionParametrosVacios')->add(\MW::class . ':ValidarParametrosUsuario');

        $app->get('/login',\Usuario::class . ':ObtenerDataJWT');

    /**BORRAR */
        $app->delete('/', \Auto::class . ':EliminarAutoPorID')->add(\MW::class . '::VerificarPropietario')->add(
            \MW::class . ':ChequearJWT');
    
    /**MODIFICAR */
        $app->put('/', \Auto::class . ':ModificarAutoPorID')->add(\MW::class . '::VerificarEncargado')->add(
            \MW::class . ':ChequearJWT');
    /**________________________________________________________________________________________________________________________________________ */

    $app->run();
?>