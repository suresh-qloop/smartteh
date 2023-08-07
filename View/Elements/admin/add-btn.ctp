<?= $this->element('admin/button', [
	'label' => __d('admin', 'Add new'),
	'url' => ['action' => 'create'],
	'compact' => true,
	'icon' => 'plus',
	'ajax' => true
]) ?>
