@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <p><strong>SKU:</strong> {{ $product->sku }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Available Stock:</strong> {{ $inventory ? $inventory->stock_level : 'N/A' }}</p>
        <p><strong>Base Price:</strong> {{ $inventory ? $inventory->cost : 'N/A' }}</p>
        @if ($pricing)
            <h4>Discounts</h4>
            <ul>
                @if (is_array($pricing->days) && count($pricing->days))
                    @foreach ($pricing->days as $day)
                        <li>{{ $day }}: {{ $pricing->discounts[$day] ?? '0' }}%</li>
                    @endforeach
                @endif
                @if ($pricing->min_quantity && $pricing->quantity_discount)
                    <li>Buy {{ $pricing->min_quantity }}+ : {{ $pricing->quantity_discount }}% off</li>
                @endif
            </ul>
        @endif
        <form method="POST" action="{{ route('shop.buy', $product->id) }}">
            @csrf
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1"
                    max="{{ $inventory ? $inventory->stock_level : 1 }}" required>
            </div>
            <button type="submit" class="btn btn-success">Buy</button>
            <a href="{{ route('shop.index') }}" class="btn btn-secondary">Back</a>
        </form>
        @if (session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif
        <div class="mt-3">
            <strong>Today's Day:</strong> {{ $today }}<br>
            <strong>Note:</strong> Final price (with all applicable discounts) will be shown after purchase.
        </div>
    </div>
@endsection
