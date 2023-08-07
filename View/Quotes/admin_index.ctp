<?php $this->set('title_for_layout', $page_title = __d('admin', 'Quotes')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<table class="list">
	<tr>
		<th class="nb"><?= __d('admin', 'Image') ?></th>
		<th class="nb"><?= __d('admin', 'Name') ?></th>
		<th class="nb"><?= __d('admin', 'Tagline') ?></th>
		<th><?= __d('admin', 'Text') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Quote']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td class="nb">
				<?php if ($v['Quote']['filename']): ?>
					<?= $this->Html->uploadedImage('quotes/'.$v['Quote']['filename']) ?>
				<?php else: ?>
					&mdash;
				<?php endif ?>
			</td>
			<td class="nb">
				<?= $v['Quote']['name'] ?>
			</td>
			<td class="nb">
				<?= $v['Quote']['tagline'] ?>
			</td>
			<td>
				<?= nl2br($v['Quote']['text']) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update'],
					'id' => $v['Quote']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<?= $this->element('admin/paginator') ?>
