<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\HttpExceptions\Http400Exception;
use App\Services\TransactionsService;
use App\Validators\Transactions\ConfirmTransactionValidator;
use App\Validators\Transactions\CreateTransactionValidator;
use Phalcon\Mvc\Controller;

class TransactionsController extends Controller
{
    private $transactionsService;

    public function onConstruct()
    {
        $this->transactionsService = new TransactionsService();
    }

    public function indexAction()
    {

    }

    public function newAction()
    {

        $request = $this->request->getJsonRawBody();
        $validation = new CreateTransactionValidator();
        $errors = $validation->validate($request);

        if($errors->count()){
            $exception = new Http400Exception(_('Body parameters validation error'), 400);
            throw $exception->addErrorDetails($errors->jsonSerialize());
        }

        return $this->transactionsService->newTransaction($request);

    }

    public function confirmAction(int $transactionId)
    {
        $request = $this->request->getJsonRawBody();
        $validation = new ConfirmTransactionValidator();
        $errors = $validation->validate($request);

        if($errors->count()){
            $exception = new Http400Exception(_('Body parameters validation error'), 400);
            throw $exception->addErrorDetails($errors->jsonSerialize());
        }

        return $this->transactionsService->confirmTransaction($transactionId, $request->auth_token);
    }

}

