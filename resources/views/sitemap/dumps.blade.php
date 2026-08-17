<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($dumpsCategories as $dumpsCategory)
        <url>
            <loc>{{  asset(config('links.link.dump').'/'.$dumpsCategory->slug) }}</loc>
            <lastmod>{{ $dumpsCategory->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>

    @endforeach
        @foreach ($dumpsItems as $dumpsItem)
            @if(isset($dumpsItem->parent))
            <url>
                <loc>{{  asset(config('links.link.dump').'/'.$dumpsItem->parent->slug .'/'.$dumpsItem->slug) }}</loc>
                <lastmod>{{ $dumpsItem->updated_at->toAtomString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
            @endif
        @endforeach

</urlset>
