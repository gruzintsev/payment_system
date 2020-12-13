<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRateRequest;
use App\Services\CurrencyRateService;
use Illuminate\Http\JsonResponse;

/**
 * Class CurrencyRateController
 * @package App\Http\Controllers\Api
 */
class CurrencyRateController extends Controller
{
    protected CurrencyRateService $currencyRateRequest;

    /**
     * CurrencyRateController constructor.
     * @param CurrencyRateService $currencyRateRequest
     */
    public function __construct(CurrencyRateService $currencyRateRequest)
    {
        $this->currencyRateRequest = $currencyRateRequest;
    }

    /**
     * @param CurrencyRateRequest $request
     * @return JsonResponse
     */
    public function create(CurrencyRateRequest $request): JsonResponse
    {
        $currencyRate = $this->currencyRateRequest->create($request->all());

        return response()->json([
            'success' => true,
            'data' => ['id' => $currencyRate->id],
        ]);
    }
}
