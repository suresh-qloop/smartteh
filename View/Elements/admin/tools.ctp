<?php if (!empty($data)): ?>
	<?php

	if (empty($id)) {
		$models = $this->request->models;
		$model = current($models);
		$model = $model['className'];
		$id = $data[$model]['id'];
	}

	if (empty($actions)) {
		$actions = ['index', 'update', 'delete'];
	}

	if (empty($controller)) {
		$controller = $this->request->controller;
	}

	$menu = [
		'index' => [
			'title' => __d('admin', 'list'),
			'url' => ['admin' => true, 'controller' => $controller, 'action' => 'index'],
			'icon' => 'list'
		],
		'update' => [
			'title' => __d('admin', 'edit'),
			'url' => ['admin' => true, 'controller' => $controller, 'action' => 'update', $id],
			'icon' => 'pencil'
		],
		'delete' => [
			'title' => __d('admin', 'delete'),
			'url' => ['admin' => true, 'controller' => $controller, 'action' => 'delete', $id],
			'icon' => 'trash',
			'class' => 'confirm'
		]
	];

	?>
	<?php if ($this->Session->check('Admin')): ?>
		<div class="admin-page-tools">
			<?php foreach ($menu as $k => $v): ?>
				<?php if (in_array($k, $actions)): ?>
					<?php

					$icon = 'dont-track fa fa-'.$v['icon'];

					if (!empty($v['class'])) {
						$v['class'] .= ' '.$icon;
					} else {
						$v['class'] = $icon;
					}

					echo $this->Html->link('', $v['url'], ['escape' => false, 'class' => $v['class'], 'title' => $v['title']]);

					?>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	<?php endif ?>
<?php endif ?>
