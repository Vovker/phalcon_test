<?php

use http\Client;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response;

$di = new FactoryDefault();

$di->setShared(
    'response',
    function () {
        $response = new Response();
        $response->setContentType('application/json', 'utf-8');

        return $response;
    }
);

$di->setShared('config', $config);

$di->set(
    "db",
    function () use ($config) {
        return new MySQL(
            [
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->dbname,
            ]
        );
    }
);

$di->set(
    "dbEmpty",
    function () use ($config) {
        return new MySQL(
            [
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
            ]
        );
    }
);

$di->set(
    'modelsManager',
    function () {
        return new \Phalcon\Mvc\Model\Manager();
    }
);




$di->set('HttpClient',
    function () {
        return new Client();
    }
);

$di->set('APICallCache', function () {$frontCache = new FrontData(); return new Memory($frontCache); });


