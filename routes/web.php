<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[UserController::class, 'index'])->middleware('guest')->name('login');
Route::get('/register',[UserController::class, 'register'])->middleware('guest')->name('register');
Route::post('/login',[UserController::class, 'login'])->name('user.login.post');
Route::post('/register',[UserController::class, 'create'])->name('user.register.post');

Route::middleware(['auth', 'user'])->group(function(){
    Route::get('/dashboard', function(){
        return view('welcome');
    })->name('dashboard');
});

Route::middleware(['auth', 'admin'])->group(function(){

    Route::get('/admin/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');