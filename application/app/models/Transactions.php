<?php

namespace Phalcon\App\app\models;

class Transactions extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $details;

    /**
     *
     * @var integer
     */
    public $sender_account_id;

    /**
     *
     * @var integer
     */
    public $receiver_account;

    /**
     *
     * @var integer
     */
    public $receiver_name;

    /**
     *
     * @var double
     */
    public $charge_amount;

    /**
     *
     * @var double
     */
    public $total;

    /**
     *
     * @var integer
     */
    public $provider_currencies_id;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var string
     */
    public $auth_token;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("transactions");
        $this->hasMany('sender_account_id', '\Users', 'id', ['alias' => 'Users']);
        $this->belongsTo('provider_currencies_id', '\ProviderCurrencies', 'id', ['alias' => 'ProviderCurrencies']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transactions[]|Transactions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transactions|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
