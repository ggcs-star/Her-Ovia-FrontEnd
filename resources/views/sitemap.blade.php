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
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>{{ url('/contact-us') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>{{ url('/privacy-policy') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

    <url>
        <loc>{{ url('/terms') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

    {{-- MAIN CATEGORIES --}}
    @foreach($categories as $cat)

        <url>
            <loc>{{ url('/collection/'.$cat['slug']) }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>

        {{-- CHILD CATEGORIES --}}
        @if(!empty($cat['children']))
            @foreach($cat['children'] as $child)

                <url>
                    <loc>{{ url('/collection/'.$child['slug']) }}</loc>
                    <changefreq>weekly</changefreq>
                    <priority>0.9</priority>
                </url>

            @endforeach
        @endif

    @endforeach

    {{-- PRODUCTS --}}
    @foreach($products as $product)

        @if(!empty($product['slug']))
            <url>
                <loc>{{ url('/product/'.$product['slug']) }}</loc>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
        @endif

    @endforeach

</urlset>