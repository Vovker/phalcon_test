<?php

namespace App\Services;

use Phalcon\App\app\models\ProviderCurrencies;
use Phalcon\App\app\models\Providers;
use Phalcon\App\app\models\Transactions;
use Phalcon\App\app\models\Users;

class TransactionsService extends AbstractService
{

    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_FAILED = 2;

    public function newTransaction(\stdClass $data)
    {
        try {

            $user = Users::findFirst($data->user_id);

            if(!$user){
                throw new ServiceException('Provided user with ID ' . $data->user_id . ' not found', 400);
            }

            $tAmountInLastHour = count(Transactions::query()
                ->where('sender_account_id = ' . $data->user_id)
                ->andWhere("updated_at >= '" . date('Y-m-d H:i:s', time() - 3600) . "'")
                ->execute()
            );

            if($tAmountInLastHour >= 10){
                throw new ServiceException('Limit of transactions in hour exceeded', 403);
            }

            $currenciesProvider = ProviderCurrencies::findFirst("currency = '". mb_strtoupper($data->currency) . "'");

            if(!$currenciesProvider){
                throw new ServiceException('Unfortunately we do not support ' . mb_strtoupper($data->currency), 404);
            }

            $provider = Providers::findFirst("id = " . $currenciesProvider->provider_id);

            //We can use equaling by id because providers will be added via migrations - it's a kind of static data
            //megacash provider
            if($provider->id == 1 && strlen($data->details) > 20){
                throw new ServiceException("Megacash supports only transaction's {details} less than 20 characters", 400);
            }

            //supermoney provider
            if($provider->id == 2){
                $data->details .= " " . rand(0, 999999);
            }

            $transaction = new Transactions();

            $feeMultiplier = $this->feesCalculation($data->user_id);
            $total = $data->amount * $feeMultiplier;

            $transaction->sender_account_id = $data->user_id;
            $transaction->details = $data->details;
            $transaction->receiver_account = $data->receiver_account;
            $transaction->receiver_name = $data->receiver_name;
            $transaction->charge_amount = $data->amount;
            $transaction->total = $total;
            $transaction->provider_currencies_id = $currenciesProvider->id;
            $transaction->status = self::STATUS_PENDING;
            $transaction->auth_token = 111;

            $result = $transaction->save();

            if(!$result) {
                throw new ServiceException('Unable to process transaction', 500);
            }

            return ['transaction_id' => $transaction->id];

        } catch (\PDOException $e) {
            throw new ServiceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function confirmTransaction(int $transactionId, string $authToken)
    {
        try {

            $transaction = Transactions::findFirst($transactionId);

            if(!$transaction){
                throw new ServiceException('Provided transaction with ID ' . $transactionId . ' not found', 400);
            }

            if($transaction->status == self::STATUS_FAILED){
                throw new ServiceException('Transaction FAILED, create the new one!', 403);
            }

            if($transaction->status == self::STATUS_COMPLETED){
                throw new ServiceException('Transaction already COMPLETED', 400);
            }

            //TODO: In this code block we should call 3rd-party API to retrieve transaction success
            //Currently hard-coded
            if($authToken === $transaction->auth_token){
                $transaction->updated_at = date('Y-m-d H:i:s');
                $transaction->status = self::STATUS_COMPLETED;
                $transaction->save();
            }
            else {
                $transaction->status = self::STATUS_FAILED;
                $transaction->save();
                throw new ServiceException('2FA token expired or invalid', 403);
            }

            return [
                'transaction_id' => $transaction->id,
                'details' => $transaction->details,
                'receiver_account' => $transaction->receiver_account,
                'receiver_name' => $transaction->receiver_name,
                'amount' => $transaction->charge_amount,
                'fee' => $transaction->total - $transaction->charge_amount,
                'status' => 'completed'
            ];

        } catch (\PDOException $e) {
            throw new ServiceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function feesCalculation(int $userId)
    {
        $totalCharge = Transactions::sum(
            [
                'column' => 'charge_amount',
                'conditions' => "sender_account_id = :user_id: AND DATE(created_at) >= :start_date: AND status != :status:",
                'bind' => [
                    'user_id' => $userId,
                    'start_date' => date('Y-m-d H:i:s', time() - 3600*24),
                    'status' => self::STATUS_FAILED
                ]
            ]
        );

        return (int)$totalCharge >= 100 ? 1.05 : 1.1;
    }

}