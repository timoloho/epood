@extends('layouts.app')

@section('content')
    <h1>Checkout</h1>

    <p>Total Amount: ${{ number_format($total, 2) }}</p>

    <form action="{{ route('shop.makePayment') }}" method="POST" id="payment-form">
        @csrf

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="card-element">Credit or debit card</label>
            <div id="card-element" class="form-control">
                <!-- A Stripe Element will be inserted here. -->
            </div>

            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
        </div>

        <input type="hidden" name="payment_method_id" id="payment_method_id">

        <button id="card-button" class="btn btn-primary" type="submit" data-secret="{{ $intent->client_secret }}">
            Pay Now
        </button>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: document.getElementById('first_name').value
                        }
                    }
                }
            );

            if (error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                document.getElementById('payment_method_id').value = setupIntent.payment_method;
                form.submit();
            }
        });
    </script>
@endsection