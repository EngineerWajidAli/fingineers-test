@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Inventory Management</h1>
        <form method="GET" action="{{ route('inventory.index') }}" class="mb-3">
            <input type="text" name="search" placeholder="Search by name or SKU" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Location</th>
                    <th>Cost</th>
                    <th>Lot</th>
                    <th>Update Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->product->sku }}</td>
                        <td>{{ $inventory->product->name }}</td>
                        <td>{{ $inventory->product->description }}</td>
                        <td>{{ $inventory->stock_level }}</td>
                        <td>{{ $inventory->location }}</td>
                        <td>{{ $inventory->cost }}</td>
                        <td>{{ $inventory->lot_number }}</td>
                        <td>
                            <form method="POST" action="{{ route('inventory.update', $inventory->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="stock_level" value="{{ $inventory->stock_level }}"
                                    min="0" style="width:70px;">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $inventories->links() }}
    </div>
@endsection
