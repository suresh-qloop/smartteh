<?php

/* @var array $menu_categories */
/* @var array $menu_industries */
/* @var array $menu_article */
/* @var array $menu_services */
/* @var array $menu_blocks */
/* @var string $from */

$c = $this->request->controller;
$a = $this->request->action;

$active_categories = $a == 'view' && ($c === 'categories' || ($c === 'products' && $from === 'category'));
$active_industries = $a == 'view' && ($c === 'industries' || ($c === 'products' && $from === 'industry'));
$active_services = $a == 'view' && ($c === 'services');
$active_articles = $c === 'articles';

$category_strid = null;


if ($menu_categories) {
	$category_strid = $menu_categories[0]['Category']['strid_' . $lang];
}

$industry_strid = null;

if ($menu_industries) {
	$industry_strid = $menu_industries[0]['Industry']['strid_' . $lang];
}
$article_strid = null;

if ($menu_article) {
	$article_strid = $menu_article[0]['Article']['strid_' . $lang];
}
$service_strid = null;

if ($menu_services) {
	$service_strid = $menu_services[0]['Service']['strid_' . $lang];
}

$items = [];

if ($category_strid) {
	$items[] = [
		'title' => __('Iekārtas'),
		'url' => ['controller' => 'categories', 'action' => 'view', $category_strid, '#' => 'categories'],
		'active' => $active_categories,
		'show' => true,
	];
}

if ($service_strid) {
	$items[] = [
		'title' => __('Pakalpojumi'),
		'url' => ['controller' => 'services', 'action' => 'view', $service_strid, '#' => 'services'],
		'active' => $active_services,
		'show' => true,
	];
}

if ($industry_strid) {
	$items[] = [
		'title' => __('Industrijas'),
		'url' => ['controller' => 'industries', 'action' => 'view', $industry_strid, '#' => 'industries'],
		'active' => $active_industries,
		'show' => true,
	];
}

if ($menu_blocks['portfolio']) {
	$items[] = [
		'title' => __('Portfolio'),
		'url' => ['controller' => 'start', 'action' => 'index', '#' => 'portfolio'],
		'show' => $menu_blocks['portfolio'],
		'active' => false
	];
}
if ($article_strid) {
	$items[] = [
		'title' => __('Blogs'),
		'url' => ['controller' => 'articles', 'action' => 'index', '#' => 'blog'],
		'active' => false,
		'show' => true,
	];
}
$items[] = [
	'title' => __('Partneri'),
	'url' => ['controller' => 'start', 'action' => 'index', '#' => 'partners'],
	'active' => false,
	'show' => true
];

$items[] = [
	'title' => __('Par mums'),
	'url' => ['controller' => 'start', 'action' => 'index', '#' => 'about-us'],
	'active' => false,
	'show' => true
];

$items[] = [
	'title' => __('Kontakti'),
	'url' => ['controller' => 'start', 'action' => 'index', '#' => 'contacts'],
	'active' => false,
	'show' => true
];

?>
<nav class="site-navbar" id="site-navbar">
	<?php
	$img = $this->Html->image('logo.png?v=2', ['alt' => 'SmartTEH', 'width' => 150, 'height' => 60]);
	echo $this->Html->link($img, ['controller' => 'start', 'action' => 'index'], ['class' => 'site-logo dont-track', 'escape' => false]);

	?>
	<div class="container display-flex">

		<div class="menu-items">
			<?php foreach ($items as $item) : ?>
				<?php

				if ($item['show']) {
					$class = 'item dont-track';
					if ($item['active']) {
						$class .= ' active';
					}

					$params = ['class' => $class];

					if (!empty($item['params'])) {
						$params = array_merge($params, $item['params']);
					}

					echo $this->Html->link($item['title'], $item['url'], $params);
				}

				?>
			<?php endforeach ?>
		</div>

	</div>
</nav>