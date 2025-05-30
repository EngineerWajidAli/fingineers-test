@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Shop Products</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td><a href="{{ route('shop.show', $product->id) }}" class="btn btn-primary btn-sm">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
@endsection
