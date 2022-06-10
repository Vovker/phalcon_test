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
     * @var integer
     */
    public $sender_account_id;

    /**
     *
     * @var string
     */
    public $details;

    /**
     *
     * @var double
     */
    public $sum;

    /**
     *
     * @var double
     */
    public $total;

    /**
     *
     * @var integer
     */
    public $receiver_account_id;

    /**
     *
     * @var string
     */
    public $receiver_account_name;

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
    public $date;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("transactions");
        $this->hasMany('receiver_account_id', 'Phalcon\App\app\models\Users', 'id', ['alias' => 'Users']);
        $this->belongsTo('sender_account_id', 'Phalcon\App\app\models\Users', 'id', ['alias' => 'Users']);
        $this->belongsTo('provider_currencies_id', 'Phalcon\App\app\models\ProviderCurrencies', 'id', ['alias' => 'ProviderCurrencies']);
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
