<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            'AUD' => 'Australian Dollar',
            'BRL' => 'Brazilian Real',
            'CAD' => 'Canadian Dollar',
            'CZK' => 'Czech Koruna',
            'DKK' => 'Danish Krone',
            'EUR' => 'Euro',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Forint',
            'ILS' => 'New Israeli Sheqel',
            'JPY' => 'Yen',
            'MYR' => 'Malaysian Ringgit',
            'MXN' => 'Mexican Peso',
            'NOK' => 'Norwegian Krone',
            'NZD' => 'New Zealand Dollar',
            'PHP' => 'Philippine Peso',
            'PLN' => 'Zloty',
            'GBP' => 'Pound Sterling',
            'RUB' => 'Russian Ruble',
            'SGD' => 'Singapore Dollar',
            'SEK' => 'Swedish Krona',
            'CHF' => 'Swiss Franc',
            'TWD' => 'New Taiwan Dollar',
            'THB' => 'Baht',
            'USD' => 'US Dollar',
        ];

        $data = [];
        foreach ($currencies as $iso => $name){
            $data[] = [
                'name' => $name,
                'iso' => $iso,
            ];
        }

        Currency::insert($data);
    }
}
