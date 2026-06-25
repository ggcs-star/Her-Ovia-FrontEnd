<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SitemapController extends Controller
{
    public function index()
    {
        $categoriesResponse = Http::get(
            'https://admin.maherajewels.com/api/categories'
        )->json();

        $allProducts = [];

        $page = 1;

        do {

            $response = Http::get(
                'https://admin.maherajewels.com/api/products?page=' . $page
            )->json();

            $products = $response['data']['products'] ?? [];

            $allProducts = array_merge($allProducts, $products);

            $lastPage = $response['data']['pagination']['last_page'] ?? 1;

            $page++;

        } while ($page <= $lastPage);

        return response()
    ->view('sitemap', [
        'categories' => $categoriesResponse['data'] ?? [],
        'products'   => $allProducts,
    ])
    ->header('Content-Type', 'text/xml');
    }
}