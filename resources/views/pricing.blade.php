@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Pricing Rules</h1>
        <form method="POST" action="{{ route('pricing.store') }}" class="mb-3">
            @csrf
            <div class="row">
                <div class="col-md-3 mt-2">
                    <select name="product_id" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->sku }} - {{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <select name="rule_type" class="form-control">
                        <option value="time">Time-based</option>
                        <option value="quantity">Quantity-based</option>
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <input type="number" name="min_quantity" placeholder="Min Qty" class="form-control">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="number" step="0.01" name="discount_amount" placeholder="Discount" class="form-control">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="number" step="0.01" name="markup_amount" placeholder="Markup" class="form-control">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="datetime-local" name="valid_from" class="form-control">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="datetime-local" name="valid_to" class="form-control">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="number" name="precedence" placeholder="Precedence" class="form-control" value="0">
                </div>
                <div class="col-md-3 mt-2">
                    <button type="submit" class="btn btn-primary w-100">Add Rule</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Min Qty</th>
                    <th>Discount</th>
                    <th>Markup</th>
                    <th>Valid From</th>
                    <th>Valid To</th>
                    <th>Precedence</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pricingRules as $rule)
                    <tr>
                        <td>{{ $rule->id }}</td>
                        <td>{{ $rule->product_id }}</td>
                        <td>{{ $rule->rule_type }}</td>
                        <td>{{ $rule->min_quantity }}</td>
                        <td>{{ $rule->discount_amount }}</td>
                        <td>{{ $rule->markup_amount }}</td>
                        <td>{{ $rule->valid_from }}</td>
                        <td>{{ $rule->valid_to }}</td>
                        <td>{{ $rule->precedence }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
