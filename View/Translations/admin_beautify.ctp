<?php $this->set('title_for_layout', $page_title = __d('admin', 'Localization').' » '.__d('admin', 'beautify')) ?>

<div class="tools">
	<?= $this->element('admin/tabs', ['data' => Translation::getAdminTabs()]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Translation', ['url' => ['action' => 'beautify']]) ?>

<?= $this->Form->input('code', [
	'style' => 'height: 600px',
	'type' => 'textarea',
	'label' => false
]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Beautify'),
	'div' => 'submit'
]) ?>

<?= $this->Form->end() ?>
