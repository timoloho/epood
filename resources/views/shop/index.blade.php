@extends('layouts.app')

@section('content')
    <h1>Products</h1>

    <div class="product-list">
        @foreach ($products as $product)
            <div class="product">
                <h2>{{ $product->name }}</h2>
                <p>Price: ${{ number_format($product->price, 2) }}</p>
                <form action="{{ route('shop.addToCart') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection