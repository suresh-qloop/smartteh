<?php $this->set('title_for_layout', $page_title = __d('admin', 'Categories').' » '.__d('admin', 'edit')) ?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>

	<?= $this->element('admin/tabs', ['data' => Category::getAdminTabs($id)]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Category', ['url' => ['action' => 'update'], 'type' => 'file']) ?>

<?= $this->Form->input('parent_id', [
	'label' => __d('admin', 'Parent category'),
	'options' => $list_categories,
	'empty' => true
]) ?>

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

<?= $this->Form->input('description_'.$lang, [
	'label' => __d('admin', 'Description'),
	'class' => 'js-rte'
]) ?>

<?= $this->Form->input('category_title_'.$lang, [
	'label' => __d('admin', 'Category title')
]) ?>

<?= $this->Form->input('products_title_'.$lang, [
	'label' => __d('admin', 'Products title')
]) ?>

<?= $this->element('admin/translated-input', ['model' => 'Category']) ?>

<?php if ($this->request->data['Category']['parent_id']): ?>
	<?= $this->element('admin/upload-element', [
		'label' => __d('admin', 'Image').' ('.Category::$IMAGE_SIZE['filename']['w'].'x'.Category::$IMAGE_SIZE['filename']['h'].' '.__d('admin', 'or').' '.Category::$IMAGE_SIZE['filename_big']['w'].'x'.Category::$IMAGE_SIZE['filename_big']['h'].')',
		'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
		'preview_dir' => '../uploads/images/categories/',
		'field' => 'filename',
		'model' => 'Category'
	]) ?>
<?php else: ?>
	<?= $this->element('admin/upload-element', [
		'label' => __d('admin', 'Image (menu)').' ('.Category::$IMAGE_SIZE['filename_menu']['w'].'x'.Category::$IMAGE_SIZE['filename_menu']['h'].')',
		'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
		'preview_dir' => '../uploads/images/categories/menu/',
		'field' => 'filename_menu',
		'model' => 'Category'
	]) ?>
<?php endif ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Header image'),
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/categories/header/',
	'field' => 'filename_header',
	'model' => 'Category'
]) ?>

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
