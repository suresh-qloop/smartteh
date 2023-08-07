<?php $this->set('title_for_layout', $page_title = __d('admin', 'Slides').' » '.__d('admin', 'edit')) ?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Slide', ['url' => ['action' => 'update'], 'type' => 'file']) ?>

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

<?php /*echo $this->element('admin/upload-element', [
		'label' => __d('admin', 'Slide image').' ('.Slide::$IMAGE_SIZE['filename']['w'].'x'.Slide::$IMAGE_SIZE['filename']['h'].')',
		'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
		'preview_dir' => '../uploads/images/slides/',
		'field' => 'filename',
		'model' => 'Slide'
	])*/ ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Background image').' ('.Slide::$IMAGE_SIZE['bg_filename']['w'].'x'.Slide::$IMAGE_SIZE['bg_filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/slides/bg/',
	'field' => 'bg_filename',
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

<?= $this->Form->hidden('id') ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
