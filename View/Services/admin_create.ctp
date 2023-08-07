<?php $this->set('title_for_layout', $page_title = __d('admin', 'Services').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Service', ['url' => ['action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('title_'.$lang, [
	'label' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('intro_'.$lang, [
	'label' => __d('admin', 'Intro')
]) ?>

<?= $this->Form->input('description_'.$lang, [
	'label' => __d('admin', 'Description'),
	'class' => 'js-rte'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image').' ('.Service::$IMAGE_SIZE['filename_brick']['w'].'x'.Service::$IMAGE_SIZE['filename_brick']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/services/brick/',
	'field' => 'filename_brick',
	'model' => 'Service'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image (menu)').' ('.Service::$IMAGE_SIZE['filename_menu']['w'].'x'.Service::$IMAGE_SIZE['filename_menu']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/services/menu/',
	'field' => 'filename_menu',
	'model' => 'Service'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image (mobile)').' ('.Service::$IMAGE_SIZE['filename_mobile']['w'].'x'.Service::$IMAGE_SIZE['filename_mobile']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/services/mobile/',
	'field' => 'filename_mobile',
	'model' => 'Service'
]) ?>

<?= $this->element('admin/translated-input', ['model' => 'Service']) ?>

<?= $this->Form->input('enabled', [
	'label' => __d('admin', 'Enabled')
]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
