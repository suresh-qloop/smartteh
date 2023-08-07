<?php $this->set('title_for_layout', $page_title = __d('admin', 'Certificates').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Certificate', ['url' => ['action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('title_'.$lang, [
	'label' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image').' ('.Certificate::$IMAGE_SIZE['filename']['w'].'x'.Certificate::$IMAGE_SIZE['filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/certificates/',
	'field' => 'filename',
	'model' => 'Certificate',
	'required' => true
]) ?>

<?= $this->element('admin/translated-input', ['model' => 'Certificate']) ?>

<?= $this->Form->input('enabled', [
	'label' => __d('admin', 'Enabled')
]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
