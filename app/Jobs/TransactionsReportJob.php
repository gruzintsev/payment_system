<?php

namespace App\Jobs;

use App\Services\TransactionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TransactionsReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = collect($data);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TransactionService $transactionService)
    {
        $fileName = 'report.csv';

        $query = $transactionService->getQuery($this->data);
        $count = $query->count();
        if ($count == 0) {
            return;
        }
        $columns = collect(['ID', 'Date', 'User From Id', 'User To Id', 'Amount', 'Currency'])->implode(',');
        $filePath = 'public/reports/' . $fileName;
        Storage::put('public/reports/' . $fileName, $columns);
        $query->chunk(100, function ($transactions) use ($filePath) {
            foreach ($transactions as $transaction) {
                $record = collect();
                $record->add($transaction->id);
                $record->add($transaction->created_at);
                $record->add($transaction->user_from_id);
                $record->add($transaction->user_to_id);
                $record->add($transaction->amount);
                $record->add($transaction->currency_iso);
                Storage::append($filePath, $record->implode(','));
            }
        });
    }
}
