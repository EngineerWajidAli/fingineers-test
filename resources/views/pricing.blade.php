@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Pricing Rules</h1>
        <form method="POST" action="{{ route('pricing.store') }}" class="mb-3">
            @csrf
            <div class="row">
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <select name="product_id" class="form-control" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->sku }} - {{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label>Day-based Discounts:</label>
                        <div class="row">
                            @foreach ($daysOfWeek as $day)
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="days[]"
                                                value="{{ $day }}" id="day_{{ $day }}">
                                            <label class="form-check-label"
                                                for="day_{{ $day }}">{{ $day }}</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="number" step="0.01" name="discounts[{{ $day }}]"
                                            placeholder="Discount % for {{ $day }}" class="form-control mt-1">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label>Quantity-based Discount:</label>
                        <input type="number" name="min_quantity" placeholder="Min Qty" class="form-control mb-2">
                        <input type="number" step="0.01" name="quantity_discount" placeholder="Discount % for Quantity"
                            class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-2">
                        <button type="submit" class="btn btn-primary w-100">Add Rule</button>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Day-based Discounts</th>
                    <th>Min Qty</th>
                    <th>Qty Discount (%)</th>
                    <th>Precedence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pricingRules as $rule)
                    <tr>
                        <td>{{ $rule->id }}</td>
                        <td>{{ $rule->product ? $rule->product->name : $rule->product_id }}</td>
                        <td>
                            @if (is_array($rule->days) && count($rule->days))
                                <ul class="mb-0">
                                    @foreach ($rule->days as $day)
                                        <li>{{ $day }}: {{ $rule->discounts[$day] ?? '0' }}%</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $rule->min_quantity ?? '-' }}</td>
                        <td>{{ $rule->quantity_discount ?? '-' }}</td>
                        <td>{{ $rule->precedence ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pricing.edit', $rule->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pricing.destroy', $rule->id) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
