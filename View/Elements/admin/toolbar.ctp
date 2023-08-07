<?php if ($this->Session->check('Admin')): ?>
	<?php

	if (!function_exists('item')) {
		function item(&$_this, $item) {
			$url = am(['admin' => true], $item['url']);
			$html = $_this->Html->link('', $url, ['class' => 'dont-track toolbar-icon fa fa-'.$item['icon']]);
			$html .= '<span class="toolbar-title">'.str_replace(' ', '&nbsp;', $item['title']).'</span>';

			return $html;
		}
	}

	include(APP.'View'.DS.'Elements'.DS.'admin'.DS.'menu-items.ctp');

	$menu[] = [
		'title' => __d('admin', 'Logout'),
		'url' => ['admin' => false, 'controller' => 'admins', 'action' => 'logout'],
		'icon' => 'sign-out'
	];

	?>
	<ul id="admin-tools">
		<?php foreach ($menu as $v): ?>
			<?php if (!empty($v['items'])): ?>
				<?php foreach ($v['items'] as $v2): ?>
					<li><?= item($this, $v2) ?></li>
				<?php endforeach ?>
			<?php else: ?>
				<li><?= item($this, $v) ?></li>
			<?php endif ?>
		<?php endforeach ?>
	</ul>
<?php endif ?>
