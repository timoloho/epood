<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('shop.index', compact('products'));
    }

    public function cart()
    {
        $cartItems = Cart::with('product')->get();
        return view('shop.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        Cart::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
        ]);

        return redirect('/cart')->with('success_message', 'Item added to cart.');
    }

    public function updateCart(Request $request)
    {
        foreach ($request->quantity as $cartId => $quantity) {
            $cart = Cart::findOrFail($cartId);
            $cart->update(['quantity' => $quantity]);
        }

        return redirect('/cart')->with('success_message', 'Cart updated.');
    }

    public function removeFromCart(Request $request)
    {
        Cart::destroy($request->cart_id);

        return redirect('/cart')->with('success_message', 'Item removed from cart.');
    }

    public function checkout()
    {
        $cartItems = Cart::with('product')->get();
        $total = $cartItems->sum(function($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = PaymentIntent::create([
            'amount' => $total * 100, // Amount in cents
            'currency' => 'USD',
        ]);

        return view('shop.checkout', compact('total', 'intent'));
    }

    public function makePayment(Request $request)
    {
        $cartItems = Cart::with('product')->get();
        $total = $cartItems->sum(function($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $intent = PaymentIntent::create([
                'amount' => $total * 100, // Amount in cents
                'currency' => 'USD',
                'payment_method' => $request->input('payment_method_id'),
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            if ($intent->status == 'succeeded') {
                // Empty the cart after successful payment
                Cart::truncate();
                return redirect('/shop')->with('success_message', 'Payment successful. Thank you!');
            } else {
                return back()->withErrors('Payment was not successful.');
            }
        } catch (\Exception $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }
}