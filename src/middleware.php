<?php

use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);

    // $app->add(new Tuupola\Middleware\JwtAuthentication([
    //     "path" => "/cms",
    //     "header" => "Authorization",
    //     "ignore" => ["/cms/admin/login", "/cliente/login"],
    //     "secure" => false,
    //     "secret" => $app->getContainer()->get('settings')['jwt']['secret'],
    //     "error" => function ($response, $arguments) {
    //         $data["status"] = "error";
    //         $data["message"] = $arguments["message"];
    //         return $response
    //             ->withHeader("Content-Type", "application/json")
    //             ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    //     }
    // ]));
};
