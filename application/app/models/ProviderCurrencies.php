<?php

namespace Phalcon\App\app\models;

class ProviderCurrencies extends \Phalcon\Mvc\Model
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
    public $provider_id;

    /**
     *
     * @var string
     */
    public $currency;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("provider_currencies");
        $this->hasMany('id', 'Phalcon\App\app\models\Transactions', 'provider_currencies_id', ['alias' => 'Transactions']);
        $this->belongsTo('provider_id', 'Phalcon\App\app\models\Providers', 'id', ['alias' => 'Providers']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderCurrencies[]|ProviderCurrencies|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderCurrencies|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
