<?php $this->set('title_for_layout', $page_title = __d('admin', 'Products')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Product', ['inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<thead>
	<tr>
		<th class="nb"><?= __d('admin', 'Image') ?></th>
		<th><?= $this->Paginator->sort('title_'.$lang, __d('admin', 'Title')) ?></th>
		<th><?= $this->Paginator->sort('manufacturer', __d('admin', 'Manufacturer')) ?></th>
		<th><?= $this->Paginator->sort('Category.title_'.$lang, __d('admin', 'Category')) ?></th>
		<th><?= $this->Paginator->sort('Industry.title_'.$lang, __d('admin', 'Industry')) ?></th>
		<th class="nb"><?= __d('admin', 'Translated') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<tr class="search-row">
		<td class="nb">&mdash;</td>
		<td><?= $this->Form->input('title_'.$lang) ?></td>
		<td><?= $this->Form->input('manufacturer') ?></td>
		<td><?= $this->Form->input('Category.title_'.$lang) ?></td>
		<td><?= $this->Form->input('Industry.title_'.$lang) ?></td>
		<td class="nb"></td>
		<td class="nb"><?= $this->element('admin/search-row-submit') ?></td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v): ?>
		<tr class="<?= ($v['Product']['enabled'] ? 'enabled' : 'disabled') ?>">
			<td class="nb">
				<?php if ($v['Product']['filename']): ?>
					<?= $this->Html->uploadedImage('products/small/'.$v['Product']['filename']) ?>
				<?php else: ?>
					<?= $this->Html->image('product.png') ?>
				<?php endif ?>
			</td>
			<td>
				<?= $this->Html->link($v['Product']['title_'.$lang], ['admin' => false, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_'.$lang]]) ?>
			</td>
			<td>
				<?= $v['Product']['manufacturer'] ?>
			</td>
			<td>
				<?php if ($v['Category']): ?>
					<?= $this->Html->link($v['Category']['title_'.$lang], ['admin' => false, 'controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$lang]]) ?>
				<?php else: ?>
					&mdash;
				<?php endif ?>
			</td>
			<td>
				<?php if ($v['Industry']): ?>
					<?= $this->Html->link($v['Industry']['title_'.$lang], ['admin' => false, 'controller' => 'industries', 'action' => 'view', $v['Industry']['strid_'.$lang]]) ?>
				<?php else: ?>
					&mdash;
				<?php endif ?>
			</td>
			<td class="nb">
				<?= $this->element('admin/translated-output', ['values' => $v['Product']['translated']]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['enable', 'disable', 'update', 'duplicate'],
					'id' => $v['Product']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?= $this->Form->end() ?>

<?= $this->element('admin/paginator') ?>
