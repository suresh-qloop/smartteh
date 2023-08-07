<?php $this->set('title_for_layout', $page_title = __d('admin', 'Products').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Product', ['url' => ['action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('category_id', [
	'label' => __d('admin', 'Category'),
	'options' => $list_categories,
	'empty' => [null => ''],
	'type' => 'select'
]) ?>

<?= $this->Form->input('industry_id', [
	'label' => __d('admin', 'Industry'),
	'options' => $list_industries,
	'empty' => [null => ''],
	'type' => 'select'
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

<?= $this->Form->input('manufacturer', [
	'label' => __d('admin', 'Manufacturer')
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image').' ('.Product::$IMAGE_SIZE['filename']['w'].'x'.Product::$IMAGE_SIZE['filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/products/small/',
	'field' => 'filename',
	'model' => 'Product',
	'required' => true
]) ?>

<?= $this->Form->input('alt_'.$lang, [
	'label' => __d('admin', 'Alt'),
	'div' => 'input text'
]) ?>

<?= $this->element('admin/translated-input', ['model' => 'Product']) ?>

<?= $this->Form->input('show_contact_form', [
	'label' => __d('admin', 'Show contact form')
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
