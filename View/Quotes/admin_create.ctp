<?php $this->set('title_for_layout', $page_title = __d('admin', 'Quotes').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Quote', ['url' => ['action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('name', [
	'label' => __d('admin', 'Name'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('tagline', [
	'label' => __d('admin', 'Tagline')
]) ?>

<?= $this->Form->input('text', [
	'div' => 'input textarea required',
	'label' => __d('admin', 'Text'),
	'required' => true
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image').' ('.Quote::$IMAGE_SIZE['filename']['w'].'x'.Quote::$IMAGE_SIZE['filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/quotes/',
	'field' => 'filename',
	'required' => true,
	'model' => 'Quote'
]) ?>

<?= $this->Form->input('enabled', [
	'label' => __d('admin', 'Enabled')
]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
