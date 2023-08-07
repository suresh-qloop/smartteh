<?php $this->set('title_for_layout', $page_title = __d('admin', 'Industries').' » '.__d('admin', 'edit')) ?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>

	<?= $this->element('admin/tabs', ['data' => Industry::getAdminTabs($id)]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Industry', ['url' => ['action' => 'update'], 'type' => 'file']) ?>

<?= $this->Form->input('title_'.$lang, [
	'label' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('strid_'.$lang, [
	'label' => __d('admin', 'Slug'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('category_title_'.$lang, [
	'label' => __d('admin', 'Category title')
]) ?>

<?= $this->Form->input('products_title_'.$lang, [
	'label' => __d('admin', 'Products title')
]) ?>

<?= $this->Form->input('intro_'.$lang, [
	'label' => __d('admin', 'Intro')
]) ?>

<?= $this->Form->input('description_'.$lang, [
	'label' => __d('admin', 'Description'),
	'class' => 'js-rte'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image (menu)').' ('.Industry::$IMAGE_SIZE['filename_menu']['w'].'x'.Industry::$IMAGE_SIZE['filename_menu']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/industries/menu/',
	'field' => 'filename_menu',
	'model' => 'Industry'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image (frontpage)').' ('.Industry::$IMAGE_SIZE['filename_brick']['w'].'x'.Industry::$IMAGE_SIZE['filename_brick']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/industries/brick/',
	'field' => 'filename_brick',
	'model' => 'Industry'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image (header)'),
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/industries/header/',
	'field' => 'filename_header',
	'model' => 'Industry'
]) ?>

<?= $this->Form->input('alt_'.$lang, [
	'label' => __d('admin', 'Alt'),
	'div' => 'input text'
]) ?>

<?= $this->element('admin/translated-input', ['model' => 'Industry']) ?>

<?= $this->Form->input('big_thumbnails', [
	'label' => __d('admin', 'Show big category images')
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
