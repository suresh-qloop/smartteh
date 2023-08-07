<?php $this->set('title_for_layout', $page_title = __d('admin', 'Administrators').' » '.__d('admin', 'password')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Admin', ['url' => ['action' => 'passwd']]) ?>

<?= $this->Form->input('password1', [
	'type' => 'password',
	'label' => __d('admin', 'Password (1x)'),
	'autocomplete' => 'off',
	'value' => ''
]) ?>

<?= $this->Form->input('password2', [
	'div' => 'input password required',
	'label' => __d('admin', 'Password (2x)'),
	'autocomplete' => 'off',
	'type' => 'password',
	'value' => ''
]) ?>

<?= $this->Form->hidden('id') ?>

<?= $this->Form->end(__d('admin', 'Save')) ?>
