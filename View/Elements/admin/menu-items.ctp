<?php

$menu = [
	[
		'title' => __d('admin', 'Administrators'),
		'url' => ['controller' => 'admins', 'action' => 'index'],
		'icon' => 'user-md'
	],
	[
		'title' => __d('admin', 'Sections'),
		'url' => ['controller' => 'sections', 'action' => 'index'],
		'icon' => 'file-text'
	],
	[
		'title' => __d('admin', 'Text snippets'),
		'url' => ['controller' => 'subsections', 'action' => 'index'],
		'icon' => 'copy'
	],
	[
		'title' => __d('admin', 'Certificates'),
		'url' => ['controller' => 'certificates', 'action' => 'index'],
		'icon' => 'file-text'
	],
	[
		'title' => __d('admin', 'Section headings'),
		'url' => ['controller' => 'section_headings', 'action' => 'index'],
		'icon' => 'copy'
	],
	[
		'title' => __d('admin', 'Categories'),
		'url' => ['controller' => 'categories', 'action' => 'index'],
		'icon' => 'sitemap'
	],
	[
		'title' => __d('admin', 'Industries'),
		'url' => ['controller' => 'industries', 'action' => 'index'],
		'icon' => 'sitemap'
	],
	[
		'title' => __d('admin', 'Services'),
		'url' => ['controller' => 'services', 'action' => 'index'],
		'icon' => 'sitemap'
	],
	[
		'title' => __d('admin', 'Products'),
		'url' => ['controller' => 'products', 'action' => 'index'],
		'icon' => 'book',
		'controllers' => ['products', 'product_images'],
	],
	[
		'title' => __d('admin', 'Portfolio'),
		'url' => ['controller' => 'portfolio', 'action' => 'index'],
		'icon' => 'list-alt',
		'controllers' => ['portfolio', 'portfolio_images'],
	],
	[
		'title' => __d('admin', 'Blog articles'),
		'url' => ['controller' => 'articles', 'action' => 'index'],
		'icon' => 'copy'
	],
	[
		'title' => __d('admin', 'Blog themes'),
		'url' => ['controller' => 'themes', 'action' => 'index'],
		'icon' => 'copy'
	],
	[
		'title' => __d('admin', 'Partners'),
		'url' => ['controller' => 'partners', 'action' => 'index'],
		'icon' => 'briefcase'
	],
	[
		'title' => __d('admin', 'Tracking'),
		'icon' => 'area-chart',
		'items' => [
			[
				'title' => __d('admin', 'URL'),
				'url' => ['controller' => 'tracking', 'action' => 'urlstats'],
				'icon' => 'link',
			],
			[
				'title' => __d('admin', 'Images'),
				'url' => ['controller' => 'tracking', 'action' => 'imagestats'],
				'icon' => 'picture-o',
			],
		]
	],
	[
		'title' => __d('admin', 'Quotes'),
		'url' => ['controller' => 'quotes', 'action' => 'index'],
		'icon' => 'quote-right'
	],
	[
		'title' => __d('admin', 'Slides'),
		'url' => ['controller' => 'slides', 'action' => 'index'],
		'icon' => 'picture-o'
	],
	[
		'title' => __d('admin', 'Contacts'),
		'url' => ['controller' => 'contacts', 'action' => 'index'],
		'icon' => 'envelope'
	],
	[
		'title' => __d('admin', 'Callbacks'),
		'url' => ['controller' => 'callbacks', 'action' => 'index'],
		'icon' => 'phone'
	],
	[
		'title' => __d('admin', 'Metatags'),
		'url' => ['controller' => 'metatags', 'action' => 'index'],
		'icon' => 'tags'
	],
	[
		'title' => __d('admin', 'Localization'),
		'url' => ['controller' => 'translations', 'action' => 'index'],
		'icon' => 'language'
	],
	[
		'title' => __d('admin', 'Settings'),
		'url' => ['controller' => 'settings', 'action' => 'index'],
		'icon' => 'cogs'
	]
];
