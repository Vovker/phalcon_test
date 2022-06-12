<?php

use Phalcon\Mvc\Micro\Collection;
use App\Controllers\TransactionsController;

$transactionsCollection = new Collection();
$transactionsCollection->setHandler(new TransactionsController());
$transactionsCollection->setPrefix('/transaction');
$transactionsCollection->post('/', 'newAction');
$transactionsCollection->put('/confirm/{transactionId}', 'confirmAction');

$app->mount($transactionsCollection);

$app->notFound(
    function () use ($app) {

        $exception =
            new \App\Controllers\HttpExceptions\Http404Exception(
                'URI not found or error in request. ('.$app->request->getMethod() . ' ' . $app->request->getURI().')',
                \App\Controllers\AbstractController::ERROR_NOT_FOUND,
                new \Exception('URI not found: ' . $app->request->getMethod() . ' ' . $app->request->getURI())
            );
        throw $exception;
    }
);

