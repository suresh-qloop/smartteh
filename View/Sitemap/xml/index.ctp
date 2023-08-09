<?php

$xmlArray = Xml::fromArray($sitemap);

echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($xmlArray->url as $url) {
    echo '<url>';
    echo '<loc>' . htmlspecialchars($url->loc) . '</loc>';
    echo '<changefreq>' . htmlspecialchars($url->changefreq) . '</changefreq>';
    echo '</url>';
}

echo '</urlset>';
?>