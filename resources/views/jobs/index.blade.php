@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Jobs
        </div>

        <div class="card-body">
            <table class="table table-dark  mt-4">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td scope="row">{{ $job->id }}</td>
                            <td>{{ $job->created_at }}</td>
                            <td><a href="{{ route('jobs.view', $job->id) }}">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (!empty($jobs))
                {{ $jobs->links() }}
            @endif
        </div>
    </div>
@endsection
