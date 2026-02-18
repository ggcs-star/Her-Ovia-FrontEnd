<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Basic Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect('/landing'));

Route::get('/login', function () {

    if (session('token')) {
        return redirect('/landing'); // Changed from /dashboard to /landing
    }

    return view('mobile.auth.login');
});

/*
|--------------------------------------------------------------------------
| Auth Pages
|--------------------------------------------------------------------------
*/

Route::view('/login', 'mobile.auth.login');
Route::view('/register', 'mobile.auth.register');
Route::view('/verify-otp', 'mobile.auth.verify');

/*
|--------------------------------------------------------------------------
| Dashboard (Frontend Protected)
|--------------------------------------------------------------------------
*/

Route::view('/dashboard', 'mobile.dashboard');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    return redirect('/login');
});