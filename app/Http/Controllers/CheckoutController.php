<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $items = $this->cart->items();
        $total = $this->cart->total();

        return view('checkout.index', compact('items', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_zip' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
        ]);

        if ($this->cart->count() === 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $totalAmount = $this->cart->total();
            
            // Create Stripe Payment Intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Convert to cents
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'user_id' => auth()->id(),
                ],
            ]);

            DB::beginTransaction();

            // Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'stripe_payment_intent_id' => $paymentIntent->id,
                ...$validated,
            ]);

            // Create Order Items
            foreach ($this->cart->items() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return view('checkout.payment', [
                'order' => $order,
                'clientSecret' => $paymentIntent->client_secret,
                'stripeKey' => config('services.stripe.key'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Update order status
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        // Clear cart
        $this->cart->clear();

        return view('checkout.success', compact('order'));
    }

    public function webhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $endpoint_secret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            if ($event->type === 'payment_intent.succeeded') {
                $paymentIntent = $event->data->object;
                
                $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();
                
                if ($order) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing',
                    ]);
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}