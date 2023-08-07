<?php

/* @var array $list_industries */
/* @var array $list_articles */
/* @var array $list_themes */

$this->set('title_for_layout', $page_title = __d('admin', 'Article').' » '.__d('admin', 'add'));

?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Article', ['url' => ['controller' => 'articles', 'action' => 'create'], 'type' => 'file']) ?>

<?= $this->Form->input('industry_id', [
	'label' => __d('admin', 'Industry'),
	'options' => $list_industries,
	'empty' => [null => ''],
	'type' => 'select'
]) ?>

<?= $this->Form->input('theme_id', [
	'label' => __d('admin', 'Blog theme'),
	'options' => $list_themes,
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
	'label' => __d('admin', 'Image').' ('.Article::$IMAGE_SIZE['filename']['w'].'x'.Article::$IMAGE_SIZE['filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG and GIF'),
	'preview_dir' => '../uploads/images/articles/',
	'field' => 'filename',
	'model' => 'Article'
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

<?= $this->Form->input('related_article1_id', [
	'label' => __d('admin', 'Related article'),
	'options' => $list_articles,
	'empty' => [null => ''],
	'type' => 'select'
]) ?>

<?= $this->Form->input('related_article2_id', [
	'label' => __d('admin', 'Related article'),
	'options' => $list_articles,
	'empty' => [null => ''],
	'type' => 'select'
]) ?>

<?= $this->Form->input('related_article3_id', [
	'label' => __d('admin', 'Related article'),
	'options' => $list_articles,
	'empty' => [null => ''],
	'type' => 'select'
]) ?>

<?= $this->element('admin/translated-input', ['model' => 'Article']) ?>

<?= $this->Form->input('enabled', [
	'label' => __d('admin', 'Enabled')
]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
