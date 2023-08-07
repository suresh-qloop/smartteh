<?php $this->set('title_for_layout', $page_title = __d('admin', 'Industries').' » '.__d('admin', 'metatags')) ?>

<div class="tools">
	<?= $this->element('admin/tabs', ['data' => Industry::getAdminTabs($id)]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->element('admin/metatags-form', [
	'controller' => $this->request->controller,
	'action' => 'view',
	'pid' => $id
]) ?>
