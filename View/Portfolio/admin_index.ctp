<?php $this->set('title_for_layout', $page_title = __d('admin', 'Portfolio')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Portfolio', ['inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<thead>
	<tr>
		<th><?= $this->Paginator->sort('title_'.$lang, __d('admin', 'Title')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('mobile_frontpage', __d('admin', 'Mobile frontpage')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('date', __d('admin', 'Date')) ?></th>
		<th class="nb"><?= __d('admin', 'Translated') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<tr class="search-row">
		<td><?= $this->Form->input('title_'.$lang) ?></td>
		<td class="nb">&nbsp;</td>
		<td class="nb"><?= $this->Form->input('date', ['class' => 'txt datepicker']) ?></td>
		<td class="nb"><?= $this->element('admin/search-row-submit') ?></td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Portfolio']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td><?= $this->Html->link($v['Portfolio']['title_'.$lang], ['admin' => false, 'action' => 'view', $v['Portfolio']['strid_'.$lang]]) ?></td>
			<td class="nb">
				<?php if ($v['Portfolio']['mobile_frontpage']): ?>
					<span class="fa fa-check color-green"></span>
				<?php else: ?>
					<span class="fa fa-times color-red"></span>
				<?php endif ?>

			</td>
			<td class="nb"><?= $this->Html->readableDate($v['Portfolio']['date']) ?></td>
			<td class="nb">
				<?= $this->element('admin/translated-output', ['values' => $v['Portfolio']['translated']]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update', 'moveup', 'movedown'],
					'id' => $v['Portfolio']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?= $this->Form->end() ?>

<?= $this->element('admin/paginator') ?>
