<?php $this->set('title_for_layout', $page_title = __d('admin', 'Certificates')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>

<table class="list">
	<tr>
		<th class="nb"><?= __d('admin', 'Image') ?></th>
		<th><?= __d('admin', 'Title') ?></th>
		<th class="nb"><?= __d('admin', 'Translated') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Certificate']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td class="nb">
				<?php if ($v['Certificate']['filename']): ?>
					<?= $this->Html->uploadedImage('certificates/'.$v['Certificate']['filename']) ?>
				<?php else: ?>
					&mdash;
				<?php endif ?>
			</td>
			<td>
				<?= $v['Certificate']['title_'.$lang] ?>
			</td>
			<td class="nb">
				<?= $this->element('admin/translated-output', ['values' => $v['Certificate']['translated']]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update', 'moveup', 'movedown'],
					'id' => $v['Certificate']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<?= $this->element('admin/paginator') ?>
