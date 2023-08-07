<?php $this->set('title_for_layout', $page_title = __d('admin', 'Partners')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>

<table class="list">
	<tr>
		<th class="nb"><?= __d('admin', 'Logo') ?></th>
		<th><?= __d('admin', 'Title') ?></th>
		<th><?= __d('admin', 'Address') ?></th>
		<th class="nb"><?= __d('admin', 'Open in new window') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Partner']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td class="nb">
				<?php if ($v['Partner']['filename']): ?>
					<?= $this->Html->uploadedImage('partners/'.$v['Partner']['filename']) ?>
				<?php else: ?>
					&mdash;
				<?php endif ?>
			</td>
			<td>
				<?= $v['Partner']['title'] ?>
			</td>
			<td><?php

				if (!empty($v['Partner']['url'])) {
					echo $this->Html->link($v['Partner']['url']);
				}

				?></td>
			<td class="nb">
				<?= $v['Partner']['new_window'] ? __d('admin', 'Yes') : __d('admin', 'No') ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update', 'moveup', 'movedown'],
					'id' => $v['Partner']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<?= $this->element('admin/paginator') ?>
