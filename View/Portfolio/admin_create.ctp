<?php

/* @var array $list_industries */

$this->set('title_for_layout', $page_title = __d('admin', 'Portfolio').' » '.__d('admin', 'add'));

?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Portfolio', ['url' => ['controller' => 'portfolio', 'action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('industry_id', [
	'label' => __d('admin', 'Industry'),
	'options' => $list_industries,
	'empty' => [null => ''],
	'type' => 'select'
]) ?>

<?= $this->Form->input('title_'.$lang, [
	'title' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>
<?= $this->Form->input('strid_'.$lang, [
	'label' => __d('admin', 'Slug'),
	'div' => 'input text required',
	'required' => true
]) ?>
<?= $this->Form->input('intro_'.$lang, [
	'label' => __d('admin', 'Intro')
]) ?>

<?= $this->Form->input('text_'.$lang, [
	'label' => __d('admin', 'Full article'),
	'class' => 'js-rte'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image (frontpage)').' ('.Portfolio::$IMAGE_SIZE['filename']['w'].'x'.Portfolio::$IMAGE_SIZE['filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/portfolio/',
	'field' => 'filename',
	'model' => 'Portfolio'
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image (industries)').' ('.Portfolio::$IMAGE_SIZE['wide']['w'].'x'.Portfolio::$IMAGE_SIZE['wide']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'field' => 'filename_wide',
	'model' => 'Portfolio'
]) ?>


<?= $this->Form->input('alt_'.$lang, [
	'label' => __d('admin', 'Alt'),
]) ?>

<?= $this->Form->input('date', [
	'class' => 'datepicker',
	'label' => __d('admin', 'Date'),
	'type' => 'text',
	'between' => '<span class="info">'.__d('admin', 'Will be publicly visible from this date').'</span>',
	'after' => '<span class="fa fa-calendar input-append"></span>'
]) ?>
<?= $this->element('admin/translated-input', ['model' => 'Portfolio']) ?>

<?= $this->Form->input('mobile_frontpage', [
	'label' => __d('admin', 'Show on mobile frontpage')
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
