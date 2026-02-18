<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Login Page
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
| Register Page
|--------------------------------------------------------------------------
*/

Route::get('/register', function () {
    return view('mobile.auth.register');
});

/*
|--------------------------------------------------------------------------
| Login Submit
|--------------------------------------------------------------------------
*/

Route::post('/login', function (Request $request) {

    $response = Http::acceptJson()->post(env('API_BASE_URL') . '/user/login', [
        'email' => $request->email,
        'password' => $request->password,
    ]);

    $data = $response->json() ?? [];

    if ($response->status() == 403) {
        session(['verify_email' => $request->email]);
        return redirect('/verify-otp')
            ->with('error', $data['message'] ?? 'Email verification required');
    }

    if ($response->successful() && isset($data['token'])) {

        session(['token' => $data['token']]);

        return redirect('/landing'); // Changed from /dashboard to /landing
    }

    return back()->with('error', $data['message'] ?? 'Login failed');
});

/*
|--------------------------------------------------------------------------
| Register Submit
|--------------------------------------------------------------------------
*/

Route::post('/register', function (Request $request) {

    \Log::info('WEB FORM DATA', $request->all());

    $response = Http::asForm()->post(
        env('API_BASE_URL') . '/user/register',
        [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]
    );

    $data = $response->json() ?? [];

    if ($response->successful()) {
        session(['verify_email' => $request->email]);
        return redirect('/verify-otp')
            ->with('success', $data['message'] ?? 'Registered successfully');
    }

    if ($response->status() == 422 && isset($data['errors'])) {
        return back()->withErrors($data['errors'])->withInput();
    }

    return back()->with('error', $data['message'] ?? 'Registration failed');
});

/*
|--------------------------------------------------------------------------
| Verify OTP
|--------------------------------------------------------------------------
*/

Route::get('/verify-otp', function () {
    return view('mobile.auth.verify');
});

Route::post('/verify-otp', function (Request $request) {

    $response = Http::acceptJson()->post(
        env('API_BASE_URL') . '/user/verify-email-otp',
        [
            'email' => session('verify_email'),
            'otp' => $request->otp,
        ]
    );

    $data = $response->json() ?? [];

    if ($response->successful()) {
        return redirect('/login')
            ->with('success', $data['message'] ?? 'Email verified. Please login.');
    }

    return back()->with('error', $data['message'] ?? 'Invalid OTP');
});

Route::get('/landing', function () {

    if (!session('token')) {
        return redirect('/login');
    }

    // 1️⃣ Categories (ONLY PARENT)
    $categoryResponse = Http::get(env('API_BASE_URL') . '/categories');

    $categories = collect($categoryResponse->json()['data'] ?? [])
        ->take(4); // sirf 4 parent categories

    \Log::info('LANDING CATEGORIES', $categories->toArray());

 $productResponse = Http::get(env('API_BASE_URL') . '/products/top-selling');

    $products = $productResponse->json()['data']['products'] ?? [];

    \Log::info('LANDING PRODUCTS', $products);

    return view('mobile.landing', compact('categories', 'products'));
});


/*
|--------------------------------------------------------------------------
| Dashboard (Optional - Agar chahein to rakhein)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $token = session('token');

    if (!$token) {
        return redirect('/login');
    }
    
    $productResponse = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Host'    => request()->getHost(),
        'Origin'  => request()->getSchemeAndHttpHost(),
        'Referer' => request()->getSchemeAndHttpHost(),
    ])->get(env('API_BASE_URL') . '/products', [
        'page' => 1
    ]);

    \Log::info('ALL PRODUCTS API RESPONSE', $productResponse->json());

    $products = $productResponse->json()['data']['products'] ?? [];

    return view('mobile.dashboard', compact('products'));
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    session()->forget('token');
    return redirect('/login');
});