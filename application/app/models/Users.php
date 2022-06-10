<?php

namespace Phalcon\App\app\models;

class Users extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var string
     */
    public $token;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("users");
        $this->hasMany('id', 'App\Models\Transactions', 'sender_account_id', ['alias' => 'Transactions']);
        $this->belongsTo('id', 'App\Models\Transactions', 'receiver_account_id', ['alias' => 'Transactions']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
