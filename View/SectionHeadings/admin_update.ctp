<?php $this->set('title_for_layout', $page_title = __d('admin', 'Section headings').' » '.__d('admin', 'edit')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('SectionHeading', ['url' => ['action' => 'update']]) ?>

<?= $this->Form->input('text', [
	'label' => __d('admin', 'Text')
]) ?>

<?= $this->Form->hidden('id') ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
