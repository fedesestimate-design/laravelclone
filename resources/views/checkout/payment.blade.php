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
@extends('layouts.app')

@section('title', 'Order Successful')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
        <p class="text-gray-600 mb-8">Thank you for your purchase. Your order has been received and is being processed.</p>

        <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
            <h2 class="text-xl font-semibold mb-4">Order Details</h2>
            
            <div class="space-y-2 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-semibold">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Date:</span>
                    <span class="font-semibold">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="font-semibold text-lg">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="border-t pt-4">
                <h3 class="font-semibold mb-2">Shipping Address:</h3>
                <p class="text-gray-700">{{ $order->shipping_name }}</p>
                <p class="text-gray-700">{{ $order->shipping_address }}</p>
                <p class="text-gray-700">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                <p class="text-gray-700">{{ $order->shipping_country }}</p>
            </div>

            <div class="border-t pt-4 mt-4">
                <h3 class="font-semibold mb-3">Order Items:</h3>
                @foreach($order->items as $item)
                    <div class="flex justify-between py-2">
                        <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4 justify-center">
            <a href="{{ route('shop.index') }}" 
               class="bg-blue-600 text-white px-8 py-3 rounded-md hover:bg-blue-700 font-semibold">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection