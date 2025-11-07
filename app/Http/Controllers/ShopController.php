<?php
// app/Http/Controllers/ShopController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function home(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('welcome', compact('products', 'categories'));
    }

    public function index(Request $request)
    {
        Log::info('Filter Request:', $request->all());

        $query = Product::with('category')->where('is_active', true);

        // Category Filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search Filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%$searchTerm%")
                ->orWhere('description', 'like', "%$searchTerm%");
            });
        }

        // Price Range Filter (use has instead of filled)
        if ($request->has('min_price')) {
            $minPrice = (float)$request->min_price;
            Log::info('Min Price Filter:', ['value' => $minPrice]);
            $query->where('price', '>=', $minPrice);
        }

        if ($request->has('max_price')) {
            $maxPrice = (float)$request->max_price;
            Log::info('Max Price Filter:', ['value' => $maxPrice]);
            $query->where('price', '<=', $maxPrice);
        }

        // Stock Availability Filter
        if ($request->has('in_stock')) {
            Log::info('In Stock Filter Applied');
            $query->where('stock_quantity', '>', 0);
        }

        // On Sale Filter
        if ($request->has('on_sale')) {
            Log::info('On Sale Filter Applied');
            // $query->where('on_sale', true);
        }

        // Sorting
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
        }

        Log::info('SQL Query:', [
            'query' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}

// app/Http/Controllers/CartController.php
