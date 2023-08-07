<?php $this->set('title_for_layout', $page_title = __d('admin', 'Slides')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<table class="list">
	<tr>
		<th><?= __d('admin', 'Slide') ?></th>
		<th><?= __d('admin', 'Address') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Slide']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td>
				<?= $v['Slide']['title'] ?>
			</td>
			<td>
				<?php

				if (!empty($v['Slide']['url'])) {
					echo $this->Html->link($v['Slide']['url']);
				}

				?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update', 'moveup', 'movedown'],
					'id' => $v['Slide']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<?= $this->element('admin/paginator') ?>
