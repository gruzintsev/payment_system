@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Transactions
        </div>

        <div class="card-body">
            <form action="{{ route('transactions') }}">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>User</label>
                        <select name="user_id" class="form-control">
                            <option value="">Choose...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if($user->id == $userId)selected="selected"@endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="dateFrom">Date from</label>
                        <input type="text" class="form-control" id="dateFrom" name="date_from" value="{{ $dateFrom }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="dateTo">Date to</label>
                        <input type="text" class="form-control" id="dateTo" name="date_to" value="{{ $dateTo }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">GO</button>

            </form>

            <table class="table table-dark  mt-4">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th>User From</th>
                        <th>User To</th>
                        <th scope="col">Amount</th>
                        <th>Currency</th>
                        <th scope="col">Amount (USD)</th>
                        <th>Status</th>
                        <th scope="col">Type</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $totalAmountUsd = 0;
                @endphp
                @foreach ($transactions as $transaction)
                    @php
                        if ($transaction->rate > 0) {
                            $amountUsd = round($transaction->amount / $transaction->rate, 2);
                            $totalAmountUsd += $amountUsd;
                        }
                    @endphp
                    <tr class="@if ($transaction->status == \App\Models\Transaction::STATUS_FAIL) bg-danger @endif">
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->user_from_id }}</td>
                        <td>{{ $transaction->user_to_id }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->currency_iso }}</td>
                        <td>{{ $amountUsd }}</td>
                        <td>{{ \App\Models\Transaction::getStatusName($transaction->status) }}</td>
                        <td>{{ $transaction->user_from_id === null ? 'Refill' : 'Transfer' }}</td>
                    </tr>
                @endforeach
                <tr class="bg-info">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $totalAmountUsd }}</td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            @if (!empty($transactions))
                {{ $transactions->links() }}
                <a href="{{ route('transactions.export', [
                    'user_id' => $userId,
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo
                ]) }}" class="btn btn-info">Export CSV</a>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        $('#dateFrom').datepicker({format: 'dd.mm.yyyy', todayHighlight: true, weekStart: 1});
        $('#dateTo').datepicker({format: 'dd.mm.yyyy', todayHighlight: true, weekStart: 1});
    </script>
@endsection
