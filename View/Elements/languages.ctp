<div class="site-header-langs">
	<?php

	$languages = Configure::read('Languages.all');

	$list = [];

	$hidden = ['ro'];

	foreach ($languages as $l => $full) {
		if (in_array($l, $hidden)) {
			continue;
		}

		$p = ['class' => 'item dont-track'];

		if ($l == $lang) {
			$p['class'] .= ' active';
		}

		if (in_array($this->request->controller, ['categories', 'products', 'services', 'industries', 'portfolio', 'sections', 'articles'])) {
			$url = am($this->request->pass, ['lang' => $l]);
		} else {
			$url = ['controller' => 'start', 'action' => 'index', 'lang' => $l];
		}

		$list[] = $this->Html->link($l, $url, $p);
	}

	echo implode('', $list);

	?>
</div>
