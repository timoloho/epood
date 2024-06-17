@extends('layouts.app')

@section('content')
    <h1>Your Cart</h1>

    @if ($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->product->name }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>${{ number_format($cartItem->product->price, 2) }}</td>
                        <td>${{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}</td>
                        <td>
                            <form action="{{ route('shop.removeFromCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $cartItem->id }}">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('shop.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
    @endif
@endsection