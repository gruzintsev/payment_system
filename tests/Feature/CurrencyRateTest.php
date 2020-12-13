<?php

namespace Tests\Feature;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class CurrencyRateTest extends TestCase
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

    public function testsCreate()
    {
        $currency = 'RUB';
        $rate = 73;
        $data = [
            'currency_iso' => $currency,
            'rate' => $rate,
        ];

        $this->post(route('currency.rate.create'), $data, $this->headers)
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseHas('currency_rates', [
            'currency_iso' => $currency,
            'rate' => $rate,
            'date' => date('Y-m-d'),
        ]);
    }
}
