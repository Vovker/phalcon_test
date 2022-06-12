<?php

namespace App\Validators\Transactions;

use Phalcon\Validation;

class CreateTransactionValidator extends Validation
{
    public function initialize()
    {
        $this->add(
            'user_id',
            new Validation\Validator\PresenceOf(
                [
                    'message' => 'The {user_id} is required`'
                ]
            )
        );

        $this->add(
            'user_id',
            new Validation\Validator\Digit(
                [
                    'message' => 'Only digits allowed'
                ]
            )
        );

        $this->add(
            'details',
            new Validation\Validator\PresenceOf(
                [
                    'message' => 'The {details} is required`'
                ]
            )
        );

        $this->add(
            'receiver_account',
            new Validation\Validator\PresenceOf(
                [
                    'message' => 'The {receiver_account} is required`'
                ]
            )
        );

        $this->add(
            'receiver_account',
            new Validation\Validator\Alnum(
                [
                    'message' => 'Only alphanumeric characters allowed'
                ]
            )
        );

        $this->add(
            'receiver_name',
            new Validation\Validator\PresenceOf(
                [
                    'message' => 'The {receiver_name} is required`'
                ]
            )
        );

        $this->add(
            'receiver_name',
            new Validation\Validator\Regex(
                [
                    'message' => 'Only alphabetic characters allowed',
                    'pattern' => '/^[a-zA-Z ]+$/'
                ]
            )
        );

        $this->add(
            'amount',
            new Validation\Validator\PresenceOf(
                [
                    'message' => 'The {amount} is required`'
                ]
            )
        );

        $this->add(
            'amount',
            new Validation\Validator\Regex(
                [
                    'message' => 'Only number allowed`',
                    'pattern' => '/^-?(?:\d+|\d*\.\d+)$/'
                ]
            )
        );

        $this->add(
            'currency',
            new Validation\Validator\PresenceOf(
                [
                    'message' => 'The {currency} is required`'
                ]
            )
        );

        $this->add(
            'currency',
            new Validation\Validator\Alpha(
                [
                    'message' => 'Only alphabetic characters allowed'
                ]
            )
        );
    }
}