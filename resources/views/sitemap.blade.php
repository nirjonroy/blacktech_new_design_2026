<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $url)
    <url>
        <loc>{{ e($url['loc']) }}</loc>
        @if (!empty($url['lastmod']))
            <lastmod>{{ e($url['lastmod']) }}</lastmod>
        @endif
        @if (!empty($url['changefreq']))
            <changefreq>{{ e($url['changefreq']) }}</changefreq>
        @endif
        @if (!empty($url['priority']))
            <priority>{{ e($url['priority']) }}</priority>
        @endif
    </url>
@endforeach
</urlset>
