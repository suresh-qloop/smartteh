<?php include(APP.'View'.DS.'Elements'.DS.'admin'.DS.'menu-items.ctp') ?>
<?php

function menuItem(&$_this, $item) {
	$item['active'] = false;

	if (empty($item['controllers'])) {
		$item['controllers'] = [$item['url']['controller']];
	}

	if (empty($item['actions'])) {
		$item['actions'] = [$_this->request->action];
	}

	if (in_array($_this->request->controller, $item['controllers'])) {
		if (in_array($_this->request->action, $item['actions'])) {
			if (!empty($item['strict'])) {
				$pass = array_slice($item['url'], 2);
				if (!array_diff($_this->request->params['pass'], $pass)) {
					$item['active'] = true;
				}
			} else {
				$item['active'] = true;
			}
		}
	}

	return $item;
}

function outputMenuItem(&$_this, $item) {
	$p = ['escape' => false, 'class' => 'nav-item'];

	$title = '<span class="text">'.$item['title'].'</span>';

	if (!empty($item['icon'])) {
		$title = '<span class="icon fa fa-fw fa-'.$item['icon'].'"></span> '.$title;
	}

	if ($item['active']) {
		$li = '<li class="active">';
	} else {
		$li = '<li>';
	}

	if (!empty($item['items'])) {
		$p['class'] .= ' nav-parent';
		$item['url'] = '#';
	}

	return $li.$_this->Html->link($title, $item['url'], $p);
}

foreach ($menu as $k => $v) {
	if (!empty($v['items'])) {
		$active_group = false;
		foreach ($v['items'] as $k2 => $v2) {
			$menu[$k]['items'][$k2] = menuItem($this, $v2);
			$active_group = $active_group || $menu[$k]['items'][$k2]['active'];
		}
		$menu[$k]['active'] = $active_group;
	} else {
		$menu[$k] = menuItem($this, $v);
	}
}

?>
<nav class="main-nav">
	<ul>
		<?php foreach ($menu as $v): ?>
			<?php /*li*/ ?>
			<?= outputMenuItem($this, $v) ?>

			<?php if (!empty($v['items'])): ?>
				<ul class="<?= $v['active'] ? 'subnav expanded' : 'subnav' ?>">
					<?php foreach ($v['items'] as $v2): ?>
						<?php /*li*/ ?>
						<?= outputMenuItem($this, $v2) ?>
						</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
			</li>
		<?php endforeach ?>
	</ul>
</nav>
