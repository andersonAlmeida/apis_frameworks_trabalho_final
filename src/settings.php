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
            // 'host' => 'localhost',
            // 'database' => 'apis_e_frameworks_2019-2-n',
            // 'username' => 'postgres',
            // 'password' => 'postgres',
            'host' => 'ec2-107-22-160-185.compute-1.amazonaws.com',
            'database' => 'dal0v7te5lb4ms',
            'username' => 'bdmueihigievke',
            'password' => '892793a6f6dce1cc72ff8d20ee8e5d735fda690805eee700efa4248c4b2dc2f7',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        "jwt" => [
            'secret' => 'progInternet2Noite20191'
        ]
    ],
];
