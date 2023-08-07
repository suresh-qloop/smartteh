<?php $this->set('title_for_layout', $page_title = __d('admin', 'Partners').' » '.__d('admin', 'edit')) ?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Partner', ['url' => ['action' => 'update'], 'type' => 'file']) ?>

<?= $this->Form->input('title', [
	'label' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('description_'.$lang, [
	'label' => __d('admin', 'Description')
]) ?>

<?= $this->Form->input('url', [
	'label' => __d('admin', 'Address')
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image').' ('.Partner::$IMAGE_SIZE['filename']['w'].'x'.Partner::$IMAGE_SIZE['filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/partners/',
	'field' => 'filename',
	'model' => 'Partner'
]) ?>

<?= $this->Form->input('new_window', [
	'label' => __d('admin', 'Open in new window')
]) ?>

<?= $this->Form->input('enabled', [
	'label' => __d('admin', 'Enabled')
]) ?>

<?= $this->Form->hidden('id') ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
