<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Entry Point
|--------------------------------------------------------------------------
*/

// Project start → Landing page
Route::get('/', fn () => redirect('/landing'));


/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/landing', fn () => view('mobile.landing'));

Route::get('/login', function () {
    if (session('token')) {
        return redirect('/landing');
    }
    return view('mobile.auth.login');
});

Route::get('/register', fn () => view('mobile.auth.register'));

Route::get('/verify-otp', fn () => view('mobile.auth.verify'));


/*
|--------------------------------------------------------------------------
| Dashboard (Optional / Protected)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (!session('token')) {
        return redirect('/login');
    }
    return view('mobile.dashboard');
});

;

Route::get('/categories', function () {
    return view('mobile.all-categories');
});

Route::get('/category', function () {
    return view('mobile.category');
});
Route::get('/category/{id}', function ($id) {
    return view('mobile.category', ['categoryId' => $id]);
});

Route::get('/products', function () {
    return view('mobile.all-products');
});

Route::get('/products/{slug}', function () {
    return view('mobile.product-detail');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});
