<?php $this->set('title_for_layout', $page_title = __d('admin', 'Administrators').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Admin', ['url' => ['action' => 'create']]) ?>

<?= $this->Form->input('name', [
	'label' => __d('admin', 'Name'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('username', [
	'between' => '<span class="info">'.__d('admin', 'Username can contain only letters and digits').'</span>',
	'label' => __d('admin', 'Username'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('email', [
	'label' => __d('admin', 'E-mail')
]) ?>

<?= $this->Form->input('password1', [
	'label' => __d('admin', 'Password (1x)'),
	'div' => 'input password required',
	'autocomplete' => 'off',
	'type' => 'password',
	'required' => true,
	'value' => ''
]) ?>

<?= $this->Form->input('password2', [
	'label' => __d('admin', 'Password (2x)'),
	'div' => 'input password required',
	'autocomplete' => 'off',
	'type' => 'password',
	'required' => true,
	'value' => ''
]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
