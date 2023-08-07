<?php $this->set('title_for_layout', $page_title = __d('admin', 'Metatags')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Metatag', ['inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<thead>
	<tr>
		<th><?= __d('admin', 'Title') ?></th>
		<th><?= __d('admin', 'Description') ?></th>
		<th><?= __d('admin', 'Keywords') ?></th>
		<th><?= __d('admin', 'Section') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<tr class="search-row">
		<td><?= $this->Form->input('title') ?></td>
		<td><?= $this->Form->input('description') ?></td>
		<td><?= $this->Form->input('keywords') ?></td>
		<td><?= $this->Form->input('comments') ?></td>
		<td class="nb"><?= $this->element('admin/search-row-submit') ?></td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v): ?>
		<tr>
			<td><?= $v['Metatag']['title'] ?></td>
			<td><?= $v['Metatag']['description'] ?></td>
			<td><?= $v['Metatag']['keywords'] ?></td>
			<td><?= $this->Html->link($v['Metatag']['comments'], ['admin' => false, 'controller' => $v['Metatag']['controller'], 'action' => $v['Metatag']['action'], $v['Metatag']['pid']]) ?></td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['update'],
					'id' => $v['Metatag']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?= $this->Form->end() ?>

<?= $this->element('admin/paginator') ?>
