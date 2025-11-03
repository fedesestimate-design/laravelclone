<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;




// Route::middleware(['auth', 'user'])->group(function(){
//     Route::get('/dashboard', function(){
//         return view('welcome');
//     })->name('dashboard');
// });

// Route::middleware(['auth', 'admin'])->group(function(){

    // Route::get('/admin/dashboard', function(){
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');

//     Route::get('/admin/dashboard', [UserController::class, 'show'])->name('admin.dashboard');

// });

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// routes/web.php

Route::get('/', function(){
    return view('welcome');
})->name('home');
// Route::get('/login', [ShopController::class, 'index'])->name('login');
// Route::get('/register', [ShopController::class, 'index'])->name('register');

Route::get('/login',[UserController::class, 'index'])->middleware('guest')->name('login');
Route::get('/register',[UserController::class, 'register'])->middleware('guest')->name('register');
Route::post('/login',[UserController::class, 'login'])->name('user.login.post');
Route::post('/register',[UserController::class, 'create'])->name('user.register.post');

Route::get('/', [ShopController::class, 'home'])->name('home');

// Shop Routes
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [ShopController::class, 'show'])->name('show');
});

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
});

// Checkout Routes
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

// Stripe Webhook
Route::post('/stripe/webhook', [CheckoutController::class, 'webhook'])->name('stripe.webhook');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// require __DIR__.'/auth.php';



// STRIPE_KEY=your_stripe_publishable_key
// STRIPE_SECRET=your_stripe_secret_key
// STRIPE_WEBHOOK_SECRET=your_stripe_webhook_secret
