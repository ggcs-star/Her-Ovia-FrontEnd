@php
echo '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
@endphp

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- HOME --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- STATIC PAGES --}}
    <url>
        <loc>{{ url('/about-us') }}</loc>
        <lastmod>{{ date('c', filemtime(resource_path('views/pages/about-us.blade.php'))) }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>


    <url>
        <loc>{{ url('/privacy-policy') }}</loc>
        <lastmod>{{ date('c', filemtime(resource_path('views/pages/privacy.blade.php'))) }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{{ url('/returns') }}</loc>
        <lastmod>{{ date('c', filemtime(resource_path('views/pages/returns.blade.php'))) }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ url('/shipping') }}</loc>
        <lastmod>{{ date('c', filemtime(resource_path('views/pages/shipping.blade.php'))) }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ url('/terms') }}</loc>
        <lastmod>{{ date('c', filemtime(resource_path('views/pages/terms.blade.php'))) }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- MAIN CATEGORIES --}}
    @foreach($categories as $cat)

        <url>
            <loc>{{ url('/collection/'.$cat['slug']) }}</loc>
            <lastmod>{{ $cat['updated_at'] }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1.0</priority>
        </url>

        {{-- CHILD CATEGORIES --}}
        @if(!empty($cat['children']))
            @foreach($cat['children'] as $child)

                <url>
                    <loc>{{ url('/collection/'.$child['slug']) }}</loc>
                    <lastmod>{{ $child['updated_at'] }}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>1.0</priority>
                </url>

            @endforeach
        @endif

    @endforeach

    {{-- PRODUCTS --}}
    @foreach($products as $product)

        @if(!empty($product['slug']))
            <url>
                <loc>{{ url('/product/'.$product['slug']) }}</loc>
                <lastmod>{{ $product['updated_at'] }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>1.0</priority>
            </url>
        @endif

    @endforeach

</urlset>