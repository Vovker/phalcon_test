<?php

namespace App\Validators\Transactions;

use Phalcon\Validation;

class ConfirmTransactionValidator extends Validation
{
    public function initialize()
    {
        $this->add(
            'auth_token',
            new Validation\Validator\PresenceOf(
                [
                    'message' => 'The {auth_token} is required`'
                ]
            )
        );
    }
}