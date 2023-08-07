<?php $this->set('title_for_layout', $page_title = __d('admin', 'Sections').' » '.__d('admin', 'edit')) ?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>

	<?= $this->element('admin/tabs', ['data' => Section::getAdminTabs($id)]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Section', ['url' => ['action' => 'update']]) ?>

<?= $this->Form->input('title_'.$lang, [
	'label' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('text_'.$lang, [
	'label' => __d('admin', 'Text'),
	'class' => 'js-rte'
]) ?>
<?= $this->Form->input('strid_'.$lang, [
	'label' => __d('admin', 'Slug'),
	'div' => 'input text required',
	'required' => true
]) ?>
<?= $this->Form->hidden('id') ?>

<?= $this->element('admin/translated-input', ['model' => 'Section']) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
