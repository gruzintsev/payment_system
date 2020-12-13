<?php

namespace Tests\Feature;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    protected $token;
    protected $headers;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');

        $payload = [
            'name' => 'Vladimir',
            'country' => 'Cyprus',
            'city' => 'Limassol',
            'currency_iso' => 'EUR',
            'password' => '1111',
            'balance' => 3500,
        ];
        $response = $this->post(route('register'), $payload, [])
            ->assertStatus(JsonResponse::HTTP_OK)
        ;

        $this->token = $response->json('success.token');
        $this->headers = ['Authorization' => 'Bearer ' . $this->token];
    }

    public function testsRefill()
    {
        $userFromId = null;
        $userToId = 1;
        $amount = 500;
        $currency = 'EUR';
        $data = [
            'to' => $userToId,
            'amount' => $amount,
            'currency' => $currency,
        ];

        $this->post(route('transfer.create'), $data, $this->headers)
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseHas('transactions', [
            'user_from_id' => $userFromId,
            'user_to_id' => $userToId,
            'currency_iso' => $currency,
            'amount' => $amount,
        ]);
    }

    public function testsTransfer()
    {
        $payload = [
            'name' => 'Vladimir2',
            'country' => 'Cyprus',
            'city' => 'Limassol',
            'currency_iso' => 'EUR',
            'password' => '1111',
            'balance' => 3500,
        ];
        $this->post(route('register'), $payload, [])
            ->assertStatus(JsonResponse::HTTP_OK)
        ;

        $userFromId = 1;
        $userToId = 2;
        $amount = 500;
        $currency = 'EUR';
        $data = [
            'to' => $userToId,
            'from' => $userFromId,
            'amount' => $amount,
            'currency' => $currency,
        ];

        $this->post(route('transfer.create'), $data, $this->headers)
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseHas('transactions', [
            'user_from_id' => $userFromId,
            'user_to_id' => $userToId,
            'currency_iso' => $currency,
            'amount' => $amount,
        ]);
    }
}
