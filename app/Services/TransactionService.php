<?php

namespace App\Services;

use App\Http\Requests\TransactionRequest;
use App\Models\LastTransactions;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    protected UserService $userService;

    /**
     * TransactionService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateStatus(Transaction $transaction, int $status)
    {
        $transaction->update(['status' => $status]);
    }

    /**
     * @param Collection $filters
     * @return Builder
     */
    public function getQuery(Collection $filters): Builder
    {
        $query = Transaction::query()
            ->where(function ($query) use ($filters) {
                $query->orWhere('transactions.user_from_id', $filters->get('user_id'))
                    ->orWhere('transactions.user_to_id', $filters->get('user_id'));
            });
        if ($filters->get('date_from')) {
            $query->where('transactions.created_at', '>=', Carbon::parse(strtotime($filters->get('date_from'))));
        }
        if ($filters->get('date_to')) {
            $query->where('transactions.created_at', '<=', Carbon::parse(strtotime($filters->get('date_to'))));
        }
        $query->leftJoin('users as u_from', 'u_from.id', '=', 'transactions.user_from_id');
        $query->leftJoin('users as u_to', 'u_to.id', '=', 'transactions.user_to_id');
        $query->addSelect('transactions.*');
        $query->addSelect(DB::raw('(
            CASE transactions.currency_iso
                WHEN u_from.currency_iso
                    THEN (
                        SELECT cr.rate
                        FROM currency_rates cr
                        WHERE cr.currency_iso = u_from.currency_iso
                        ORDER BY cr.date DESC
                        LIMIT 1
                        )
                WHEN u_to.currency_iso
                    THEN (
                        SELECT cr.rate
                        FROM currency_rates cr
                        WHERE cr.currency_iso = u_to.currency_iso
                        ORDER BY cr.date DESC
                        LIMIT 1
                        )
                ELSE (
                       SELECT cr.rate
                       FROM currency_rates cr
                       WHERE cr.currency_iso = transactions.currency_iso
                       ORDER BY cr.date DESC
                       LIMIT 1
                   )
            END) as rate'));

        return $query;
    }

    /**
     * @param Collection $filters
     * @return LengthAwarePaginator
     */
    public function getPaginated(Collection $filters): LengthAwarePaginator
    {
        return $this
            ->getQuery($filters)
            ->paginate(config('pagination.transactions'));
    }

    /**
     * Создать транзакцию
     * @param TransactionRequest $data
     * @return mixed
     */
    public function create(TransactionRequest $data)
    {
        $userFrom = $this->userService->getById($data['from']);
        $userTo = $this->userService->getById($data['to']);

        $transaction = Transaction::create([
            'user_from_id' => $userFrom ? $userFrom->id : null,
            'user_to_id' => $userTo->id,
            'currency_iso' => $data['currency'],
            'amount' => $data['amount'],
        ]);

        return $transaction->id;
    }

    /**
     * Возвращает одну новую транзакцию
     * @return Transaction
     */
    public function getNewFirstOne(): Transaction
    {
        return Transaction::query()
            ->where('status', Transaction::STATUS_NEW)
            ->orderBy('created_at')
            ->get()
            ->first();
    }

    /**
     * Обработать транзакцию
     *
     * @param Transaction $transaction
     */
    public function handle(Transaction $transaction): void
    {
        try {
            DB::transaction(function () use ($transaction) {
                $userFrom = $this->userService->getById($transaction->user_from_id);
                $userTo = $this->userService->getById($transaction->user_to_id);

                $this->userService->addToBalance($userTo, $transaction->amount, $transaction->currency_iso);
                if ($transaction->user_from_id) {
                    $this->userService->minusToBalance($userFrom, $transaction->amount, $transaction->currency_iso);
                }

                $transaction->update(['status' => Transaction::STATUS_COMPLETE]);
                LastTransactions::create(['id' => $transaction->id]);
            });
        } catch (\Exception $exception) {
            $transaction->update(['status' => Transaction::STATUS_FAIL]);
            Log::info('transaction:handle fail ID:' . $transaction->id . ' Message:' . $exception->getMessage());
        }
    }
}
