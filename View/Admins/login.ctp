<?php $this->set('title_for_layout', $page_title = __d('admin', 'Content Management System')) ?>

<?= $this->Form->create('Admin', ['url' => ['action' => 'login']]) ?>

<?= $this->Form->input('username', [
	'placeholder' => __d('admin', 'Username'),
	'label' => false
]) ?>

<?= $this->Form->input('password', [
	'placeholder' => __d('admin', 'Password'),
	'type' => 'password',
	'label' => false
]) ?>

<div class="input submit">
	<?= $this->element('admin/button', [
		'label' => __d('admin', 'Login'),
		'icon' => 'lock',
		'div' => false
	]) ?>

	<?= $this->Html->link(__d('admin', 'Back to site'), '/') ?>
</div>

<?= $this->Form->end() ?>
