<?php $this->set('title_for_layout', $page_title = __d('admin', 'Sections')) ?>

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
		<tr>
			<td><?= $this->Html->link($v['Section']['title_'.$lang], ['admin' => false, 'controller' => 'sections', 'action' => 'view', $v['Section']['strid_'.$lang]]) ?></td>
			<td class="nb">
				<?= $this->element('admin/translated-output', ['values' => $v['Section']['translated']]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['update'],
					'id' => $v['Section']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<?= $this->element('admin/paginator') ?>
