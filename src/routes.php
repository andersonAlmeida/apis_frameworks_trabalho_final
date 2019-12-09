<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

// use Controllers\AtracaoController;
// use Controllers\AtracaoCategoriaController;
// use Controllers\AdministradorController;
// use Controllers\NivelController;
// use Controllers\FotoController;
// use Controllers\AvaliacaoController;
// use Controllers\CupomController;

use Controllers\ProdutoController;
use Controllers\ClienteController;
use Controllers\PedidoController;
use Controllers\EnderecoController;

header('Access-Control-Allow-Origin: *');

return function (App $app) {
    $container = $app->getContainer();

    // Cliente
    $app->group('/clientes', function() use ($app, $container) {

        $app->post('[/]', function($request, $response, $args) {
            return ClienteController::inserir($request, $response, $args);
        });

        $app->get('/{id}[/]', function($request, $response, $args) {
            return ClienteController::buscarPorId($request, $response, $args);
        });

        $app->put('/{id}[/]', function($request, $response, $args) {
            return ClienteController::atualizar($request, $response, $args);
        });

        $app->post('/login[/]', function($request, $response, $args) use ($app, $container){
            $sk = $container->get('settings')['jwt']['secret'];
            return ClienteController::login($request, $response, $args, $sk);
        });

        $app->get('/fblogin/{fbid}[/]', function($request, $response, $args) use ($app, $container){
            $sk = $container->get('settings')['jwt']['secret'];
            return ClienteController::buscarPorIdFb($request, $response, $args, $sk);
        });

        // Endereço
        $app->get('/enderecos/{id}[/]', function($request, $response, $args) {
            return EnderecoController::listar($request, $response, $args);
        });

        $app->delete('/enderecos/{id}[/]', function($request, $response, $args) {
            return EnderecoController::deletar($request, $response, $args);
        });

        $app->get('/endereco/{userid}/{id}[/]', function($request, $response, $args) {
            return EnderecoController::buscarPorId($request, $response, $args);
        });

        $app->post('/enderecos[/]', function($request, $response, $args) {
            return EnderecoController::inserir($request, $response, $args);
        });

        $app->put('/enderecos/{userid}/{id}[/]', function($request, $response, $args) {
            return EnderecoController::atualizar($request, $response, $args);
        });
    });

    // produtos
    $app->group('/produtos', function() use ($app, $container) {
        $app->get('[/]', function($request, $response, $args) {
            return ProdutoController::listar($request, $response, $args);
        });

        $app->get('/{id}[/]', function($request, $response, $args) {
            return ProdutoController::buscarPorId($request, $response, $args);
        });
    });

    // pedidos
    $app->group('/pedidos', function() use ($app, $container) {
        $app->get('/{id}[/]', function($request, $response, $args) {
            return PedidoController::listar($request, $response, $args);
        });

        $app->post('[/]', function($request, $response, $args) {
            return PedidoController::inserir($request, $response, $args);
        });
    });

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    // Catch-all route to serve a 404 Not Found page if none of the routes match
    // NOTE: make sure this route is defined last
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($req, $res) {
        $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
        return $handler($req, $res);
    });
};
