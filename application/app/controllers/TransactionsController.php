<?php
declare(strict_types=1);


use Phalcon\Mvc\Controller;

class TransactionsController extends Controller
{

    private $usersModel;
    private $providerCurrenciesModel;

    public function initialize()
    {
        $this->usersModel = new Users();
        $this->providerCurrenciesModel = new ProviderCurrencies();
    }

    public function indexAction()
    {

    }

    public function newAction(int $userId)
    {
        $this->view->disable();
    }

    public function confirmAction(int $id)
    {
        $this->view->disable();
    }

}

