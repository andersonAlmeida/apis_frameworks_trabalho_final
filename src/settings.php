<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Eloquent config
        'db' => [
            'driver' => 'pgsql',
            'host' => 'localhost',
            'database' => 'apis_e_frameworks_2019-2-n',
            'username' => 'postgres',
            'password' => 'postgres',
            // 'host' => 'ec2-107-22-238-217.compute-1.amazonaws.com',
            // 'database' => 'd9nofmav13flqe',
            // 'username' => 'fltpmuyogmazrf',
            // 'password' => '6c2208abc3947d0fbb4dcb3d4a9fa03953d61854ab35d5c4446024404e60049a',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        "jwt" => [
            'secret' => 'progInternet2Noite20191'
        ]
    ],
];
