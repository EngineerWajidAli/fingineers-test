@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Inventory Management</h1>
        <form method="POST" action="{{ route('inventory.store') }}" class="mb-3">
            @csrf
            <div class="row">
                <div class="col">
                    <select name="product_id" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->sku }} - {{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="number" name="stock_level" placeholder="Stock Level" class="form-control" required>
                </div>
                <div class="col">
                    <input type="text" name="location" placeholder="Location" class="form-control">
                </div>
                <div class="col">
                    <input type="number" step="0.01" name="cost" placeholder="Cost" class="form-control">
                </div>
                <div class="col">
                    <input type="text" name="lot_number" placeholder="Lot Number" class="form-control">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Add Inventory</button>
                </div>
            </div>
        </form>
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
