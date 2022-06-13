<?php

namespace Tests\TransactionTests;

use Phalcon\Incubator\Test\PHPUnit\UnitTestCase;
use Phalcon\Mvc\Micro;
use GuzzleHttp\Client;
use Phalcon\Di;

final class TransactionTest extends UnitTestCase
{

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function testIncorrectMethod()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost/transaction', ['http_errors' => false]);
        $responseBody = json_decode($response->getBody(), true);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(404, $responseBody['code']);
        $this->assertEquals('Not Found', $responseBody['message']);
        $this->assertEquals(404, $responseBody['description']['error']);
        $this->assertEquals('URI not found or error in request. (GET /transaction)', $responseBody['description']['error_description']);
    }

    public function testCreateTransactionSuccess()
    {
        $requestData = json_encode(
            [
                'user_id' => '1',
                'details' => 'Test Transaction',
                'receiver_account' => '12345678',
                'receiver_name' => 'Account holder name',
                'amount' => '100.00',
                'currency' => 'USD'
            ]
        );

        $client = new Client();
        $response = $client->request('POST', 'http://localhost/transaction', ['body' => $requestData]);

        $responseBody = json_decode($response->getBody(), true);

        $this->assertEquals(200, $responseBody['code']);
        $this->assertEquals('OK', $responseBody['message']);
        $this->assertIsString($responseBody['data']['transaction_id']);

    }

    public function testConfirmTransactionSuccess()
    {

        //CREATE NEW TRANSACTION TO RETRIEVE ID
        $createTransactionRequestData =
            [
                'user_id' => '1',
                'details' => 'Test Transaction',
                'receiver_account' => '12345678',
                'receiver_name' => 'Account holder name',
                'amount' => '100.00',
                'currency' => 'USD'
            ];

        $client = new Client();
        $createTransactionResponse = $client->request('POST', 'http://localhost/transaction', ['body' => json_encode($createTransactionRequestData, true)]);

        $transaction_id = json_decode($createTransactionResponse->getBody(), true)['data']['transaction_id'];


        //CONFIRM TRANSACTION BLOCK

        $requestData = json_encode(
            [
                'auth_token' => "111"
            ]
        );

        $client = new Client();
        $response = $client->request('PUT', 'http://localhost/transaction/confirm/' . $transaction_id, ['body' => $requestData]);

        $responseBody = json_decode($response->getBody(), true);

        $this->assertEquals(200, $responseBody['code']);
        $this->assertEquals('OK', $responseBody['message']);
        $this->assertEquals($transaction_id, $responseBody['data']['transaction_id']);
        $this->assertNotEmpty($responseBody['data']['details']);
        $this->assertEquals($createTransactionRequestData['receiver_account'], $responseBody['data']['receiver_account']);
        $this->assertEquals($createTransactionRequestData['receiver_name'], $responseBody['data']['receiver_name']);
        $this->assertEquals((int)$createTransactionRequestData['amount'], $responseBody['data']['amount']);
        $this->assertEquals((int)($createTransactionRequestData['amount'] * 0.05), $responseBody['data']['fee']);
        $this->assertEquals('completed', $responseBody['data']['status']);

    }
}