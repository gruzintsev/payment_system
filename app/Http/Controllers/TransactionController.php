<?php

namespace App\Http\Controllers;

use App\Jobs\TransactionsReportJob;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    protected UserService $userService;

    /**
     * TransactionController constructor.
     * @param TransactionService $transactionService
     * @param UserService $userService
     */
    public function __construct(TransactionService $transactionService, UserService $userService)
    {
        $this->transactionService = $transactionService;
        $this->userService = $userService;
    }

    /**
     * Транзакции
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $users = $this->userService->get(10);//TODO change
        $filters = collect($request->all());

        $transactions = [];
        if ($filters->get('user_id')) {
            $transactions = $this->transactionService->getPaginated($filters);
        }

        return view('transactions.index', [
            'transactions' => $transactions,
            'users' => $users,
            'dateFrom' => $request->query('date_from'),
            'dateTo' => $request->query('date_to'),
            'userId' => $request->query('user_id'),
        ]);
    }

    /**
     * Экспорт транзакций в csv
     * @param Request $request
     * @return RedirectResponse
     */
    public function export(Request $request): RedirectResponse
    {
        dispatch(new TransactionsReportJob($request->all()));

        $message = 'Успешно поставлена задача на экспорт отчета в CSV. <a href="' . route('jobs') . '">Посмотреть задачи</a> Файл отчета будет доступен по <a href="/storage/reports/report.csv">ссылке</a>';

        return back()->with('message', $message);
    }

}
