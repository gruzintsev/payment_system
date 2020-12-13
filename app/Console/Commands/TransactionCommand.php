<?php

namespace App\Console\Commands;

use App\Services\TransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It handles transactions';


    protected TransactionService $transactionService;

    /**
     * Create a new command instance.
     *
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        parent::__construct();

        $this->transactionService = $transactionService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('transaction:handle start...');
        $transaction = $this->transactionService->getNewFirstOne();
        if (!$transaction) {
            return;
        }

        $this->transactionService->handle($transaction);
        Log::info('transaction:handle end...');
    }
}
