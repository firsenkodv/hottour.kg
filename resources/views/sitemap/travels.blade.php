<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($travelCategories as $travelCategory)
        <url>
            <loc>{{  asset(config('links.link.hottour').'/'.$travelCategory->slug) }}</loc>
            <lastmod>{{ $travelCategory->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>

    @endforeach
        @foreach ($travelItems as $travelItem)
            @if(isset($travelItem->parent))
            <url>
                <loc>{{  asset(config('links.link.hottour').'/'.$travelItem->parent->slug .'/'.$travelItem->slug) }}</loc>
                <lastmod>{{ $travelItem->updated_at->toAtomString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
            @endif
        @endforeach
</urlset>
