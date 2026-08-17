<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($dumpsCategories2 as $dumpsCategory2)
        <url>
            <loc>{{  asset(config('links.link.dump2').'/'.$dumpsCategory2->slug) }}</loc>
            <lastmod>{{ $dumpsCategory2->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>

    @endforeach
       @foreach ($dumpsItems2 as $dumpsItem2)
            @if(isset($dumpsItem2->parent))
            <url>
                <loc>{{  asset(config('links.link.dump2').'/'.$dumpsItem2->parent->slug .'/'.$dumpsItem2->slug) }}</loc>
                <lastmod>{{ $dumpsItem2->updated_at->toAtomString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
            @endif
        @endforeach

</urlset>
