<?php $this->set('title_for_layout', $page_title = __d('admin', 'Text snippets').' » '.__d('admin', 'add')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Subsection', ['url' => ['action' => 'create']]) ?>

<?= $this->Form->input('title', [
	'title' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('text', [
	'label' => __d('admin', 'Text'),
	'class' => 'js-rte'
]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
