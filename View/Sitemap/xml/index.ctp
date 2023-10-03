<?xml version="1.0" encoding="UTF-8"?>
		
	<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

	<sitemap>
			<loc><?php echo Router::url('/', true) ?>sitemap-general.xml</loc>
			<lastmod><?php echo date('Y-m-d',time()) ?></lastmod>
	</sitemap>
	
	<sitemap>
			<loc><?php echo Router::url('/', true) ?>sitemap-images.xml</loc>
			<lastmod><?php echo date('Y-m-d',time()) ?></lastmod>
	</sitemap>
	
	<sitemap>
			<loc><?php echo Router::url('/', true) ?>sitemap-posts.xml</loc>
			<lastmod><?php echo date('Y-m-d',time()) ?></lastmod>
	</sitemap>
	
	</sitemapindex>