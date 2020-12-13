<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    protected CurrencyRateService $currencyRateService;

    public function __construct(CurrencyRateService $currencyRateService)
    {
        $this->currencyRateService = $currencyRateService;
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        return User::create($data);
    }

    public function get($limit)
    {
        return User::query()->limit($limit)->get();
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function updateBalance(User $user, $sum, $currency, $operation)
    {
        $sum = $this->currencyRateService->convertToUsd($sum, $currency);

        $newBalance = $this->currencyRateService->convertToUsd($user->balance, $user->currency_iso);

        if ($operation === '+') {
            $newBalance += $sum;
        } else {
            $newBalance -= $sum;
        }
        $newBalance = $this->currencyRateService->convertUsdTo($newBalance, $user->currency_iso);

        $user->update(['balance' => $newBalance]);
    }

    public function addToBalance(User $user, $sum, $currency)
    {
        $this->updateBalance($user, $sum, $currency, '+');
    }

    public function minusToBalance(User $user, $sum, $currency)
    {
        $this->updateBalance($user, $sum, $currency, '-');
    }
}
