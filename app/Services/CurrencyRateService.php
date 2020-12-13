<?php

namespace App\Services;

use App\Models\CurrencyRate;

/**
 * Class CurrencyRateService
 * @package App\Services
 */
class CurrencyRateService
{
    /**
     * Создать рейт
     * @param array $data
     * @return CurrencyRate
     */
    public function create(array $data): CurrencyRate
    {
        $data['date'] = now()->format('Y-m-d');

        return CurrencyRate::create($data);
    }

    /**
     * Возвращает последний рейт
     * @param string $currency
     * @return CurrencyRate
     */
    public function getLastRate(string $currency): CurrencyRate
    {
        return CurrencyRate::query()
            ->where('currency_iso', $currency)
            ->orderBy('date')
            ->get()
            ->first();
    }

    /**
     * Конвертация в USD
     *
     * @param float $amount
     * @param string $currency
     * @return float|int
     * @throws \Exception
     */
    public function convertToUsd(float $amount, string $currency)
    {
        $lastRate = $this->getLastRate($currency);
        if (!$lastRate) {
            throw new \Exception();
        }

        return $amount / $lastRate->rate;
    }

    /**
     * Конвертация usd в другую валюту
     *
     * @param float $amount
     * @param string$currency
     * @return float|int
     * @throws \Exception
     */
    public function convertUsdTo(float $amount, string $currency)
    {
        $lastRate = $this->getLastRate($currency);
        if (!$lastRate) {
            throw new \Exception();
        }

        return $amount * $lastRate->rate;
    }
}
