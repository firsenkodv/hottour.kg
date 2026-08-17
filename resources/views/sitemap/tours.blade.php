<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($tours as $tour)
        <url>
            <loc>{{  asset(config('links.link.tours').'/'.$tour->slug) }}</loc>
            <lastmod>{{ $tour->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>

    @endforeach
</urlset>
