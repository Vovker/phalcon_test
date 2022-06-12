<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
        'App\Controllers' => realpath(__DIR__ . '/../controllers'),
        'App\Models' => realpath(__DIR__ . '/../models'),
        'App\Services' => realpath(__DIR__ . '/../services'),
        'App\Validators' => realpath(__DIR__ . '/../validators')
    ]
);

$loader->register();
