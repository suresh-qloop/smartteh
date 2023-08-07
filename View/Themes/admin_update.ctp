<?php

/* @var array $list_industries */
/* @var array $list_themes */

$this->set('title_for_layout', $page_title = __d('admin', 'Theme').' » '.__d('admin', 'edit'));

?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>

	<?= $this->element('admin/tabs', ['data' => Theme::getAdminTabs($id)]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Theme', ['url' => ['controller' => 'themes', 'action' => 'update'], 'type' => 'file']) ?>

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

<?= $this->Form->input('date', [
	'class' => 'datepicker',
	'label' => __d('admin', 'Date'),
	'type' => 'text',
	'between' => '<span class="info">'.__d('admin', 'Will be publicly visible from this date').'</span>',
	'after' => '<span class="fa fa-calendar input-append"></span>'
]) ?>

<?= $this->element('admin/translated-input', ['model' => 'Theme']) ?>

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
