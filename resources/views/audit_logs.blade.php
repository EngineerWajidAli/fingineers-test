@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Audit Logs</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Transaction</th>
                    <th>Action</th>
                    <th>Details</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($auditLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->transaction_id }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->details }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $auditLogs->links() }}
    </div>
@endsection
