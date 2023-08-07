<?php $this->set('title_for_layout', $page_title = __d('admin', 'Services')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<table class="list">
	<tr>
		<th><?= __d('admin', 'Title') ?></th>
		<th class="nb"><?= __d('admin', 'Translated') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Service']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td>
				<?= $this->Html->link($v['Service']['title_'.$lang], ['admin' => false, 'controller' => 'services', 'action' => 'view', $v['Service']['strid_'.$lang]]) ?>
			</td>
			<td class="nb">
				<?= $this->element('admin/translated-output', ['values' => $v['Service']['translated']]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update', 'moveup', 'movedown'],
					'id' => $v['Service']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
