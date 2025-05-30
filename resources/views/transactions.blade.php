@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Transactions</h1>
        <form method="POST" action="{{ route('transactions.store') }}" class="mb-3">
            @csrf
            <div class="row">
                <div class="col">
                    <input type="text" name="product_id" placeholder="Product ID" class="form-control" required>
                </div>
                <div class="col">
                    <input type="number" name="quantity" placeholder="Quantity" class="form-control" required>
                </div>
                <div class="col">
                    <select name="transaction_type" class="form-control">
                        <option value="sale">Sale</option>
                        <option value="restock">Restock</option>
                        <option value="adjustment">Adjustment</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Process</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->product_id }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>{{ $transaction->transaction_type }}</td>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $transactions->links() }}
    </div>
@endsection
