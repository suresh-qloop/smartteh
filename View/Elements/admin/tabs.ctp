<div class="tabs">
	<?php

	$defaults = [
		'title' => __d('admin', 'Untitled'),
		'show' => true,
		'icon' => false,
		'ajax' => true,
		'url' => false
	];

	foreach ($data as $v) {
		$options = am($defaults, $v);

		if (!$options['show']) {
			continue;
		}

		$p = [];
		$class = [];

		if ($options['icon']) {
			$options['title'] = '<span class="fa fa-'.$options['icon'].'"></span>'.$options['title'];
			$p['escape'] = false;
		}

		if (!$options['ajax']) {
			$class[] = 'no-ajax';
		}
		if (isset($options['url']['controller']) && isset($options['url']['action'])) {

			if ($options['url']['controller'] == $this->request->controller && $options['url']['action'] == str_replace('admin_', '', $this->request->action)) {
				$class[] = 'active';
			}
		}

		if ($class) {
			$p['class'] = implode(' ', $class);
		}

		echo $this->Html->link($options['title'], $options['url'], $p);

	}

	?>
</div>
