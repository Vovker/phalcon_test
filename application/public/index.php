<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    // Composer autoload
    require_once (__DIR__ . '/../../vendor/autoload.php');

    // Load config
    $config = require (APP_PATH . '/config/config.php');

    // Auto loading
    require APP_PATH . '/config/loader.php';

    //Initial DI container
    require APP_PATH . '/config/di.php';

    $app = new Micro();
    $app->setDI($di);

    require APP_PATH . '/config/router.php';

    $app->after(
        function () use ($app) {
            $return = $app->getReturnedValue();

            if(is_array($return)){
                $app->response->setContent(json_encode(
                    [
                        'code' => 200,
                        'message' => 'OK',
                        'data' => $return
                    ]
                ));
            }
            else {
                throw new \App\Controllers\HttpExceptions\Http500Exception('Bad response', 500);
            }
        }
    );

    $app->handle($_SERVER['REQUEST_URI']);
} catch (\Throwable $e) {
    $result = [
        'code' => $e->getCode(),
        'message' => $e->getMessage(),
    ];

    if(!empty($e->appError)){
        $result += ['description' => $e->appError];
    }

    $app->response->setStatusCode($e->getCode(), $e->getMessage())
        ->setJsonContent($result);

}

$app->response->send();