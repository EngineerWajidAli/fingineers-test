@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Edit Pricing Rule</h1>
        <form method="POST" action="{{ route('pricing.update', $rule->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mt-2">
                    <label>Day-based Discounts:</label>
                    <div class="row">
                        @foreach ($daysOfWeek as $day)
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]"
                                            value="{{ $day }}" id="day_{{ $day }}"
                                            {{ is_array($rule->days) && in_array($day, $rule->days) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="day_{{ $day }}">{{ $day }}</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <input type="number" step="0.01" name="discounts[{{ $day }}]"
                                        placeholder="Discount % for {{ $day }}" class="form-control mt-1"
                                        value="{{ is_array($rule->discounts) && isset($rule->discounts[$day]) ? $rule->discounts[$day] : '' }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label>Quantity-based Discount:</label>
                    <input type="number" name="min_quantity" placeholder="Min Qty" class="form-control mb-2"
                        value="{{ $rule->min_quantity }}">
                    <input type="number" step="0.01" name="quantity_discount" placeholder="Discount % for Quantity"
                        class="form-control" value="{{ $rule->quantity_discount }}">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="number" name="precedence" placeholder="Precedence" class="form-control"
                        value="{{ $rule->precedence }}">
                </div>
                <div class="col-md-3 mt-2">
                    <button type="submit" class="btn btn-success w-100">Update Rule</button>
                    <a href="{{ route('pricing.index') }}" class="btn btn-secondary w-100 mt-2">Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection
