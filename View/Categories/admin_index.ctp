<?php $this->set('title_for_layout', $page_title = __d('admin', 'Categories')) ?>

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
		<tr class="<?= ($v['Category']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td>
				<?php

				$url = ['admin' => false, 'controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$lang]];

				$padding = str_repeat('—', $v['Category']['_level']);

				if ($v['Category']['_level'] > 0) {
					$padding .= '&nbsp;';
				}

				echo $padding.$this->Html->link($v['Category']['title_'.$lang], $url);

				?>
			</td>
			<td class="nb">
				<?= $this->element('admin/translated-output', ['values' => $v['Category']['translated']]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update', 'moveup', 'movedown'],
					'id' => $v['Category']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
