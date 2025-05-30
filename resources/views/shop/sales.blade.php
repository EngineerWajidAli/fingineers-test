@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>My Purchases</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->product ? $sale->product->name : $sale->product_id }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ $sale->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $sales->links() }}
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
    </div>
@endsection
