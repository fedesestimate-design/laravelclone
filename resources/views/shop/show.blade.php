<!-- resources/views/shop/show.blade.php -->
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <div>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 text-xl">No Image</span>
                    </div>
                @endif
            </div>

            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $product->category->name }}</p>
                
                <div class="mt-6">
                    <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold text-lg">Description</h3>
                    <p class="text-gray-700 mt-2">{{ $product->description }}</p>
                </div>

                <div class="mt-6">
                    <span class="text-gray-700">Availability: </span>
                    @if($product->stock > 0)
                        <span class="text-green-600 font-semibold">In Stock ({{ $product->stock }} available)</span>
                    @else
                        <span class="text-red-600 font-semibold">Out of Stock</span>
                    @endif
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-8">
                        @csrf
                        <div class="flex items-center gap-4">
                            <label class="text-gray-700">Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-20 rounded-md border-gray-300">
                        </div>
                        <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 text-lg font-semibold">
                            Add to Cart
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <a href="{{ route('shop.show', $related->slug) }}">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" 
                                     alt="{{ $related->name }}" 
                                     class="w-full h-48 object-cover rounded-t-lg">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-t-lg"></div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold">{{ $related->name }}</h3>
                                <p class="text-xl font-bold mt-2">${{ number_format($related->price, 2) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection