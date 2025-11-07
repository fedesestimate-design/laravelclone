@extends('layouts.app')

@section('title', 'Shop')



@section('content')

<style>
     .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Price Range Slider Styling */
    input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        background: #2563eb;
        border: 3px solid white;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s;
    }

    input[type="range"]::-webkit-slider-thumb:hover {
        background: #1d4ed8;
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    input[type="range"]::-moz-range-thumb {
        width: 18px;
        height: 18px;
        background: #2563eb;
        border: 3px solid white;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s;
    }

    input[type="range"]::-moz-range-thumb:hover {
        background: #1d4ed8;
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>

<div class="bg-gradient-to-br from-slate-50 via-white to-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <!-- Header Section -->
        <div class="mb-8 md:mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-3 tracking-tight">
                Discover Products
            </h1>
            <p class="text-slate-600 text-lg">Find exactly what you're looking for</p>
        </div>
        
        <!-- Search Bar -->
        {{-- <div class="mb-8 md:mb-12">
            <form action="{{ route('shop.index') }}" method="GET" class="relative max-w-2xl">
                @foreach(request()->except(['search', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           placeholder="Search products..." 
                           value="{{ request('search') }}"
                           class="w-full pl-12 pr-24 py-4 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-slate-900 placeholder-slate-400 shadow-sm hover:border-slate-300">
                    <button type="submit" 
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-6 py-2.5 rounded-xl hover:bg-blue-700 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/30">
                        Search
                    </button>
                </div>
            </form>
        </div> --}}

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            {{-- <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-8">
                    <h3 class="font-bold text-lg text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Categories
                    </h3>
                    <nav class="space-y-1">
                        @php $currentCategory = request('category'); @endphp
                        <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => null])) }}"
                           class="group flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200
                                  @unless($currentCategory)
                                      bg-blue-50 text-blue-700 font-semibold shadow-sm ring-2 ring-blue-500/20
                                  @else
                                      text-slate-700 hover:bg-slate-50 hover:text-slate-900
                                  @endunless">
                            <span>All Products</span>
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
                               class="group flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200
                                      @if($currentCategory === $category->slug)
                                          bg-blue-50 text-blue-700 font-semibold shadow-sm ring-2 ring-blue-500/20
                                      @else
                                          text-slate-700 hover:bg-slate-50 hover:text-slate-900
                                      @endif">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                           @if($currentCategory === $category->slug)
                                               bg-blue-100 text-blue-700
                                           @else
                                               bg-slate-100 text-slate-600 group-hover:bg-slate-200
                                           @endif">
                                    {{ $category->products_count }}
                                </span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside> --}}
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden sticky top-8">
                    <!-- Filter Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-lg text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                                Filters
                            </h3>
                            @if(request()->hasAny(['category', 'search', 'min_price', 'max_price', 'sort', 'in_stock', 'on_sale']))
                                <a href="{{ route('shop.index') }}" 
                                class="text-xs text-white/90 hover:text-white font-medium flex items-center gap-1 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear All
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                        <form id="filterForm"action="{{ route('shop.index') }}" method="GET">
                           
                            <!-- Search Filter -->
                            <div class="pb-6 border-b border-slate-200">
                                <label class="block text-sm font-semibold text-slate-700 mb-3">Search Products</label>
                                <div class="relative">
                                    <input type="text" 
                                        name="search" 
                                        value="{{ request('search') }}"
                                        placeholder="Search products..."
                                        class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <svg class="absolute left-3 top-3 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="pb-6 border-b border-slate-200">
                                <label class="block text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Categories
                                </label>
                                <div class="space-y-2">
                                    @php $currentCategory = request('category'); @endphp
                                    
                                    <!-- All Products Option -->
                                    <label class="flex items-center justify-between p-3 rounded-lg cursor-pointer transition-all hover:bg-slate-50
                                                @unless($currentCategory) bg-blue-50 ring-2 ring-blue-500/30 @endunless">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" 
                                                name="category" 
                                                value="" 
                                                @unless($currentCategory) checked @endunless
                                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                            <span class="text-sm font-medium @unless($currentCategory) text-blue-700 @else text-slate-700 @endunless">
                                                All Products
                                            </span>
                                        </div>
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full @unless($currentCategory) bg-blue-100 text-blue-700 @else bg-slate-100 text-slate-600 @endunless">
                                            {{ $products->total() }}
                                        </span>
                                    </label>

                                    <!-- Category Options -->
                                    @foreach($categories as $category)
                                        <label class="flex items-center justify-between p-3 rounded-lg cursor-pointer transition-all hover:bg-slate-50
                                                    @if($currentCategory === $category->slug) bg-blue-50 ring-2 ring-blue-500/30 @endif">
                                            <div class="flex items-center gap-3">
                                                <input type="radio" 
                                                    name="category" 
                                                    value="{{ $category->slug }}" 
                                                    @if($currentCategory === $category->slug) checked @endif
                                                    class="w-4 h-4 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                                <span class="text-sm font-medium @if($currentCategory === $category->slug) text-blue-700 @else text-slate-700 @endif">
                                                    {{ $category->name }}
                                                </span>
                                            </div>
                                            <span class="text-xs font-semibold px-2 py-1 rounded-full @if($currentCategory === $category->slug) bg-blue-100 text-blue-700 @else bg-slate-100 text-slate-600 @endif">
                                                {{ $category->products_count }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Range Filter -->
                            <div class="pb-6 border-b border-slate-200">
                                <label class="block text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Price Range
                                </label>
                                <div class="space-y-4">
                                    <div>
                                        <input type="range" 
                                            id="priceRange" 
                                            min="0" 
                                            max="5000" 
                                            value="{{ request('max_price', 5000) }}"
                                            class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                                    </div>
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex-1">
                                            <label class="text-xs text-slate-600 mb-1 block">Min Price</label>
                                            <input type="number" 
                                                name="min_price" 
                                                value="{{ request('min_price') }}"
                                                min="0"
                                                placeholder="$0"
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div class="text-slate-400 mt-5">—</div>
                                        <div class="flex-1">
                                            <label class="text-xs text-slate-600 mb-1 block">Max Price</label>
                                            <input type="number" 
                                                id="maxPriceInput"
                                                name="max_price" 
                                                value="{{ request('max_price') }}"
                                                max="5000"
                                                placeholder="$5000"
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sort By Filter -->
                            <div class="pb-6 border-b border-slate-200">
                                <label class="block text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                    </svg>
                                    Sort By
                                </label>
                                <select name="sort" 
                                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-700 cursor-pointer">
                                    <option value="">Default</option>
                                    <option value="name_asc" @if(request('sort') === 'name_asc') selected @endif>Name: A to Z</option>
                                    <option value="name_desc" @if(request('sort') === 'name_desc') selected @endif>Name: Z to A</option>
                                    <option value="price_asc" @if(request('sort') === 'price_asc') selected @endif>Price: Low to High</option>
                                    <option value="price_desc" @if(request('sort') === 'price_desc') selected @endif>Price: High to Low</option>
                                    <option value="newest" @if(request('sort') === 'newest') selected @endif>Newest First</option>
                                    <option value="oldest" @if(request('sort') === 'oldest') selected @endif>Oldest First</option>
                                </select>
                            </div>

                            <!-- Stock Availability Filter -->
                            <div class="pb-6">
                                <label class="block text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Availability
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 p-3 rounded-lg cursor-pointer hover:bg-slate-50 transition-all">
                                        <input type="checkbox" 
                                            name="in_stock" 
                                            value="1"
                                            @if(request('in_stock')) checked @endif
                                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                                        <span class="text-sm font-medium text-slate-700">In Stock Only</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-lg cursor-pointer hover:bg-slate-50 transition-all">
                                        <input type="checkbox" 
                                            name="on_sale" 
                                            value="1"
                                            @if(request('on_sale')) checked @endif
                                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                                        <span class="text-sm font-medium text-slate-700">On Sale</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Apply Filters Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>


            <!-- Products Grid -->
            <main class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <article class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:shadow-slate-200 hover:-translate-y-1 transition-all duration-300">
                            <a href="{{ route('shop.show', $product->slug) }}" class="block relative overflow-hidden aspect-square">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($product->stock === 0)
                                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
                                        <span class="bg-white text-slate-900 px-4 py-2 rounded-full font-semibold text-sm">
                                            Out of Stock
                                        </span>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="p-5">
                                <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full mb-3">
                                    {{ $product->category->name }}
                                </span>
                                
                                <a href="{{ route('shop.show', $product->slug) }}" 
                                   class="block font-bold text-lg text-slate-900 hover:text-blue-600 transition-colors mb-3 line-clamp-2 leading-snug">
                                    {{ $product->name }}
                                </a>
                                
                                <div class="flex items-baseline gap-3 mb-4">
                                    <span class="text-2xl font-bold text-slate-900">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    
                                    @if($product->stock > 0 && $product->stock < 5)
                                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                                            Only {{ $product->stock }} left
                                        </span>
                                    @elseif($product->stock >= 5)
                                        <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                            In Stock
                                        </span>
                                    @endif
                                </div>
                                
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            @if($product->stock === 0) disabled @endif
                                            class="w-full py-3 rounded-xl font-semibold transition-all duration-200
                                                   @if($product->stock > 0)
                                                       bg-slate-900 text-white hover:bg-slate-800 hover:shadow-lg hover:shadow-slate-900/20 active:scale-95
                                                   @else
                                                       bg-slate-200 text-slate-400 cursor-not-allowed
                                                   @endif">
                                        @if($product->stock > 0)
                                            Add to Cart
                                        @else
                                            Out of Stock
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <div class="max-w-md mx-auto">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">No products found</h3>
                                <p class="text-slate-600">Try adjusting your search or filters to find what you're looking for.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>
</div>


@endsection