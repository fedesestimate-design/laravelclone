<!-- resources/views/checkout/payment.blade.php -->
@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Complete Payment</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Order #{{ $order->order_number }}</h2>
            <p class="text-2xl font-bold text-gray-900">Total: ${{ number_format($order->total_amount, 2) }}</p>
        </div>

        <form id="payment-form">
            <div id="payment-element" class="mb-4"></div>
            <button id="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                <span id="button-text">Pay Now</span>
                <span id="spinner" class="hidden">Processing...</span>
            </button>
            <div id="payment-message" class="hidden mt-4 text-red-600"></div>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const options = {
        clientSecret: '{{ $clientSecret }}',
        appearance: {
            theme: 'stripe',
        },
    };

    const elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit');
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('button-text');
    const messageContainer = document.getElementById('payment-message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        setLoading(true);

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: '{{ route("checkout.success", $order) }}',
            },
        });

        if (error) {
            showMessage(error.message);
            setLoading(false);
        }
    });

    function setLoading(isLoading) {
        if (isLoading) {
            submitButton.disabled = true;
            spinner.classList.remove('hidden');
            buttonText.classList.add('hidden');
        } else {
            submitButton.disabled = false;
            spinner.classList.add('hidden');
            buttonText.classList.remove('hidden');
        }
    }

    function showMessage(messageText) {
        messageContainer.classList.remove('hidden');
        messageContainer.textContent = messageText;
    }
</script>
@endsection

<!-- resources/views/checkout/success.blade.php -->
