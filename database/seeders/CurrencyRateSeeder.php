<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyRateSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_rates')->truncate();
        $currencyRates = [
            '2020-12-12' => [
                'USD' => 1,
                'RUB' => 73,
                'EUR' => 0.8,
            ],
            '2020-12-13' => [
                'RUB' => 80,
                'EUR' => 0.85,
            ],
            '2020-12-14' => [
                'RUB' => 85,
                'EUR' => 0.9,
            ],
        ];

        $data = [];
        foreach ($currencyRates as $date => $currencies){
            foreach ($currencies as $currency => $rate) {
                $data[] = [
                    'currency_iso' => $currency,
                    'rate' => $rate,
                    'date' => $date,
                ];
            }
        }

        CurrencyRate::insert($data);
    }
}
