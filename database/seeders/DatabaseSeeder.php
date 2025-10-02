<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
     
        // Create Categories
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and accessories'
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion and apparel'
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books and magazines'
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Home improvement and garden supplies'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'description' => 'High-quality wireless headphones with noise cancellation and 30-hour battery life.',
                'price' => 199.99,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Smart Watch',
                'slug' => 'smart-watch',
                'description' => 'Feature-rich smartwatch with fitness tracking, heart rate monitor, and GPS.',
                'price' => 299.99,
                'stock' => 35,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Laptop Stand',
                'slug' => 'laptop-stand',
                'description' => 'Ergonomic aluminum laptop stand with adjustable height and angle.',
                'price' => 49.99,
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Cotton T-Shirt',
                'slug' => 'cotton-t-shirt',
                'description' => 'Premium 100% cotton t-shirt, comfortable and durable.',
                'price' => 29.99,
                'stock' => 200,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Denim Jeans',
                'slug' => 'denim-jeans',
                'description' => 'Classic fit denim jeans with stretch fabric for comfort.',
                'price' => 79.99,
                'stock' => 75,
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Programming Guide',
                'slug' => 'programming-guide',
                'description' => 'Comprehensive guide to modern programming techniques and best practices.',
                'price' => 39.99,
                'stock' => 60,
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Fiction Novel',
                'slug' => 'fiction-novel',
                'description' => 'Bestselling fiction novel with captivating storyline.',
                'price' => 24.99,
                'stock' => 120,
                'is_active' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Garden Tool Set',
                'slug' => 'garden-tool-set',
                'description' => 'Complete 10-piece garden tool set with carrying case.',
                'price' => 89.99,
                'stock' => 45,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}