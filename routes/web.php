<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| Entry Point
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Project start → Landing page
Route::get('/', function () {
    return view('mobile.landing');
});


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
Route::get('/forgot-password', fn () => view('mobile.auth.forgot-password'));
Route::get('/reset-password', function () {
    return view('mobile.auth.reset-password');
});

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
Route::get('/category/{id}', function() {
    return view('mobile.all-categories');
});
Route::get('/categories', function () {
    return view('mobile.all-categories');
});

Route::get('/category', function () {
    return view('mobile.category');
});
Route::get('/search', function () {
    return view('mobile.search');
});
Route::get('/collection/{categorySlug}', function ($categorySlug) {
    return view('mobile.products');
});
Route::get('/collection/{categorySlug}/{subcategorySlug}', function ($categorySlug, $subcategorySlug) {
    return view('mobile.products');
});
Route::get('/all-products', function () {
    return view('mobile.all-products');
})->name('all.products');

Route::get('/product/{slug}', function ($slug) {
    return view('mobile.product-detail', ['slug' => $slug]);
})->name('product.detail');
Route::get('/top-selling', function () {
    return view('mobile.products');
})->name('top.selling');
Route::get('/best-selling', function () {
    return view('mobile.products');
})->name('best.selling');
Route::get('/cart', function () {
    return view('mobile.cart');
});
Route::get('/products', function () {
    return view('mobile.products');
});
Route::get('/coupon-terms', function () {
    return view('mobile.coupon-terms');
})->name('coupon.terms');
Route::get('/wishlist', function () {
    return view('mobile.wishlist');
});
Route::get('/orders', function () {
    return view('mobile.orders');
})->name('orders');
Route::get('/subcategory/{id}', function($id) {
    return view('mobile.subcategory');
});
Route::get('/checkout/shipping', function () {
    return view('mobile.checkout');
});
Route::get('/profile', function () {
    return view('mobile.profile');
});
Route::get('/order-confirmation/{orderId}', function ($orderId) {
    return view('mobile.order-confirmation', ['orderId' => $orderId]);
});
Route::get('/trends', function () {
    return view('mobile.trends');
})->name('trends');
Route::get('/terms', function () {
    return view('pages.terms');
});
Route::get('/returns', function () {
    return view('pages.returns');
});
Route::get('/privacy-policy', function () {
    return view('pages.privacy');
});
Route::get('/shipping', function () {
    return view('pages.shipping');
})->name('shipping');
Route::get('/about-us', function () {
    return view('pages.about-us');
})->name('about.us');
Route::fallback(function () {
    return view('errors.404');
});
// routes/web.php - Last me ye daalo

Route::get('/blog', function () {
    return view('errors.404');
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
