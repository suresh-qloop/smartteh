<?php $this->set('title_for_layout', $page_title = __d('admin', 'Slides').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Slide', ['url' => ['action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('title', [
	'label' => __d('admin', 'Title')
]) ?>

<?= $this->Form->input('color', [
	'label' => __d('admin', 'Title color'),
	'div' => 'input select required',
	'options' => $list_colors,
	'empty' => [null => ''],
	'required' => true,
	'type' => 'select'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Background image').' ('.Slide::$IMAGE_SIZE['bg_filename']['w'].'x'.Slide::$IMAGE_SIZE['bg_filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/slides/bg/',
	'field' => 'bg_filename',
	'required' => true,
	'model' => 'Slide'
]) ?>

<?= $this->Form->input('url', [
	'label' => __d('admin', 'Address')
]) ?>

<?= $this->Form->input('new_window', [
	'label' => __d('admin', 'Open in new window')
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
