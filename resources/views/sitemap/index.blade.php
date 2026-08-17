<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ route('s_pages') }}</loc>
        <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('s_travels') }}</loc>
        <lastmod>{{ $travel->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('s_tours') }}</loc>
        <lastmod>{{ $tour->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('s_dumps') }}</loc>
        <lastmod>{{ $tour->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('s_dumps2') }}</loc>
        <lastmod>{{ $tour->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('s_countries') }}</loc>
        <lastmod>{{ $country->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    {{--отели выводим отдельно--}}
    @if($hotels)

        @foreach($hotels as $hotel)
            <sitemap>
                <loc>{{ asset($hotel) }}</loc>
            </sitemap>
        @endforeach


    @endif
    <sitemap>
        <loc>{{ asset(config('links.link.contacts'))}}</loc>
    </sitemap>

</sitemapindex>
