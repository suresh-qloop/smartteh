<?php $this->set('title_for_layout', $page_title = __d('admin', 'Article')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Article', ['inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<thead>
	<tr>
		<th><?= $this->Paginator->sort('title_'.$lang, __d('admin', 'Title')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('date', __d('admin', 'Date')) ?></th>
		<th class="nb"><?= __d('admin', 'Translated') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<tr class="search-row">
		<td><?= $this->Form->input('title_'.$lang) ?></td>
		<td class="nb"><?= $this->Form->input('date', ['class' => 'txt datepicker']) ?></td>
		<td class="nb">&nbsp;</td>
		<td class="nb"><?= $this->element('admin/search-row-submit') ?></td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Article']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td><?= $this->Html->link($v['Article']['title_'.$lang], ['admin' => false, 'action' => 'view', $v['Article']['strid_'.$lang]]) ?></td>
			<td class="nb"><?= $this->Html->readableDate($v['Article']['date']) ?></td>
			<td class="nb">
				<?= $this->element('admin/translated-output', ['values' => $v['Article']['translated']]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update'],
					'id' => $v['Article']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?= $this->Form->end() ?>

<?= $this->element('admin/paginator') ?>
