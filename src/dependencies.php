<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // Service factory for the ORM
    $capsule = new \Illuminate\Database\Capsule\Manager;

    // echo $_SERVER['SERVER_NAME'];
    // die();

    if( $_SERVER['SERVER_NAME'] == "localhost" ) {
        $capsule->addConnection($container['settings']['db']);
    } else {
        $capsule->addConnection($container['settings']['db_prod']);
    }

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $container['db'] = function ($container) use ($capsule) {
        return $capsule;
    };

    // Controllers
    // $container[Controllers\AdministradorController::class] = function ($c) {
    //     $table = $c->get('db')->table('administrador');
    //     return new Controllers\AdministradorController( $table );
    // };
};
