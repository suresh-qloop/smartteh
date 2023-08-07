<?php

foreach ($buttons as $button) {
	if (is_array($button)) {

		// custom button

		$item = $button;
	} else {

		// preset

		if (!isset($controller)) {
			$controller = $this->request->controller;
		}

		if (substr($button, -9, 9) === '-disabled') {
			$button = substr($button, 0, -9);
			$disabled = true;
		} else {
			$disabled = false;
		}

		switch ($button) {
			case 'enable':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'active', $id, '1'],
					'title' => __d('admin', 'enable'),
					'class' => 'fa fa-fw fa-eye-slash'
				];
				break;

			case 'disable':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'active', $id, '0'],
					'title' => __d('admin', 'disable'),
					'class' => 'fa fa-fw fa-eye'
				];
				break;

			case 'update':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'update', $id],
					'title' => __d('admin', 'edit'),
					'class' => 'fa fa-fw fa-pencil'
				];
				break;

			case 'moveup':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'moveup', $id],
					'title' => __d('admin', 'move up'),
					'class' => 'fa fa-fw fa-arrow-circle-up'
				];
				break;

			case 'movedown':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'movedown', $id],
					'title' => __d('admin', 'move down'),
					'class' => 'fa fa-fw fa-arrow-circle-down'
				];
				break;

			case 'login':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'login', $id],
					'title' => __d('admin', 'login as user'),
					'class' => 'fa fa-fw fa-sign-in no-ajax'
				];
				break;

			case 'images':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'images', $id],
					'title' => __d('admin', 'images'),
					'class' => 'fa fa-fw fa-picture-o'
				];
				break;

			case 'delete':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'delete', $id],
					'title' => __d('admin', 'delete'),
					'class' => 'fa fa-fw fa-trash confirm'
				];
				break;

			case 'view':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'view', $id],
					'title' => __d('admin', 'view'),
					'class' => 'fa fa-fw fa-search'
				];
				break;

			case 'duplicate':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'duplicate', $id],
					'title' => __d('admin', 'duplicate'),
					'class' => 'fa fa-fw fa-files-o no-ajax'
				];
				break;
			case 'finished':
				$item = [
					'url' => ['controller' => $controller, 'action' => 'finished', $id],
					'title' => __d('admin', 'finished'),
					'class' => 'fa fa-fw fa-check'
				];
				break;
			default:
				$item = null;
		}
	}

	if (!isset($item['url']) || !isset($item['class'])) {
		$item = [
			'url' => "javascript:alert('".__d('admin', 'Warning: this button is broken')."')",
			'title' => __d('admin', 'Warning: this button is broken'),
			'class' => 'fa fa-fw fa-warning no-ajax'
		];
	} else {
		if (!empty($disabled)) {
			$item['url'] = 'javascript:void(0)';
			$item['class'] .= ' no-ajax disabled';
		}
	}

	$url = $item['url'];
	unset($item['url']);
	$params = $item;

	echo $this->Html->link('', $url, $params);
}

?>
