@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('jobs') }}">Jobs</a> > Job {{ $job->id }}
        </div>

        <div class="card-body">
            <a href="{{ asset('storage/reports/report.csv') }}">Download the report</a>
        </div>
    </div>
@endsection
