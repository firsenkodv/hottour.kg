<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ asset(config('links.link.countries')) }}</loc>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach ($countryCategories as $category)

        @if(is_null($category->hot_category_id))

        <url>
            <loc>{{  asset(config('links.link.countries').'/'.$category->slug) }}</loc>
            <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        @else
            @if($category->parent)
                <url>
                    <loc>{{  asset(config('links.link.countries').'/'.$category->parent->slug.'/'.$category->slug) }}</loc>
                    <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
                    <changefreq>monthly</changefreq>
                    <priority>1.0</priority>
                </url>


            @endif
        @endif
    @endforeach
   @foreach ($infos as $info)
        @if(isset($info->parent))
            <url>
                <loc>{{  asset(config('links.link.countries').'/'.$info->parent->parent->slug.'/'.$info->parent->slug .'/'.$info->slug) }}</loc>
                <lastmod>{{ $info->updated_at->toAtomString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        @endif
    @endforeach
    @foreach ($resorts as $resort)
        @if(isset($resort->parent))
            <url>
                <loc>{{  asset(config('links.link.countries').'/'.$resort->parent->parent->slug.'/'.$resort->parent->slug .'/'.$resort->slug) }}</loc>
                <lastmod>{{ $resort->updated_at->toAtomString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        @endif
    @endforeach
    @foreach ($excursions as $excursion)
        @if(isset($excursion->parent))
            <url>
                <loc>{{  asset(config('links.link.countries').'/'.$excursion->parent->parent->slug.'/'.$excursion->parent->slug .'/'.$excursion->slug) }}</loc>
                <lastmod>{{ $excursion->updated_at->toAtomString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        @endif
    @endforeach
</urlset>
