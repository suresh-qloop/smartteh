<?php $this->set('title_for_layout', $page_title = __d('admin', 'Sections').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Section', ['url' => ['action' => 'create']]) ?>

<?= $this->Form->input('title_'.$lang, [
	'label' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('text_'.$lang, [
	'label' => __d('admin', 'Text'),
	'class' => 'js-rte'
]) ?>
<?= $this->element('admin/translated-input', ['model' => 'Section']) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
