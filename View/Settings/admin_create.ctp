<?php $this->set('title_for_layout', $page_title = __d('admin', 'Settings').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Setting', ['url' => ['action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('id', [
	'label' => __d('admin', 'ID'),
	'type' => 'text'
]) ?>

<?= $this->Form->input('title', [
	'label' => __d('admin', 'Title')
]) ?>

<?= $this->Form->input('type', [
	'data-toggle-block' => 'setting-type',
	'label' => __d('admin', 'Type'),
	'type' => 'select',
	'options' => [
		'varchar' => __d('admin', 'String'),
		'text' => __d('admin', 'Text'),
		'select' => __d('admin', 'List'),
		'percents' => __d('admin', 'Percents'),
		'int' => __d('admin', 'Number'),
		'boolean' => __d('admin', 'Yes/No'),
		'file' => __d('admin', 'File')
	]
]) ?>

<div class="disabled hidden" data-block="setting-type" data-block-values="select">
	<?= $this->Form->input('data', [
		'label' => __d('admin', 'List values (JSON format)'),
		'disabled' => true
	]) ?>
</div>

<div class="disabled hidden" data-block="setting-type" data-block-values="file">
	<?= $this->element('admin/upload-element', [
		'label' => __d('admin', 'File'),
		'preview_dir' => '../uploads/settings/',
		'field' => 'value',
		'disabled' => true,
		'model' => 'Setting'
	]) ?>
</div>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
