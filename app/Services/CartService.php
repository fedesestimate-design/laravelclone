<?php
// app/Services/CartService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const CART_SESSION_KEY = 'cart';

    public function add(Product $product, int $quantity = 1): void
    {
        $cart = $this->get();
        $productId = $product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        session([self::CART_SESSION_KEY => $cart]);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->get();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            session([self::CART_SESSION_KEY => $cart]);
        }
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();
        unset($cart[$productId]);
        session([self::CART_SESSION_KEY => $cart]);
    }

    public function get(): array
    {
        return session(self::CART_SESSION_KEY, []);
    }

    public function clear(): void
    {
        session()->forget(self::CART_SESSION_KEY);
    }

    public function count(): int
    {
        return array_sum(array_column($this->get(), 'quantity'));
    }

    public function total(): float
    {
        $cart = $this->get();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function items(): Collection
    {
        return collect($this->get());
    }
}