<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

/**
 * Class TransactionController
 * @package App\Http\Controllers\Api
 */
class TransactionController extends Controller
{
    protected TransactionService $transferService;

    /**
     * TransactionController constructor.
     * @param TransactionService $transferService
     */
    public function __construct(TransactionService $transferService)
    {
        $this->transferService = $transferService;
    }

    /**
     * @param TransactionRequest $request
     * @return JsonResponse
     */
    public function create(TransactionRequest $request): JsonResponse
    {
        $transactionId = $this->transferService->create($request);

        return response()->json([
            'success' => true,
            'data' => ['transaction_id' => $transactionId],
        ]);
    }

}
