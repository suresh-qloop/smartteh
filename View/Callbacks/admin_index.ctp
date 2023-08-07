<?php $this->set('title_for_layout', $page_title = __d('admin', 'Callbacks')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Callbacks', ['inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<tr>
		<th><?= $this->Paginator->sort('name', __d('admin', 'Name')) ?></th>
		<th><?= $this->Paginator->sort('email', __d('admin', 'E-mail')) ?></th>
		<th><?= $this->Paginator->sort('phone', __d('admin', 'Phone')) ?></th>
		<th><?= $this->Paginator->sort('Product.title_'.$lang, __d('admin', 'Product')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('created', __d('admin', 'Date')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('get_news', __d('admin', 'News')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('finished', __d('admin', 'Status')) ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<tr class="search-row">
		<td><?= $this->Form->input('name') ?></td>
		<td><?= $this->Form->input('email') ?></td>
		<td><?= $this->Form->input('phone') ?></td>
		<td><?= $this->Form->input('Product.title_'.$lang) ?></td>
		<td class="nb"><?= $this->Form->input('created', ['class' => 'txt datepicker']) ?></td>
		<td class="nb">&nbsp;</td>
		<td class="nb">&nbsp;</td>
		<td class="nb"><?= $this->element('admin/search-row-submit') ?></td>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr>
			<td><?= h($v['Callbacks']['name']) ?></td>
			<td><?= h($v['Callbacks']['email']) ?></td>
			<td><?= h($v['Callbacks']['phone']) ?></td>
			<td>
				<?php if (!empty($v['Product']['id'])): ?>
					<?= $this->Html->link($v['Product']['title_'.$lang], ['admin' => false, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_'.$lang]]) ?>
				<?php endif ?>
			</td>
			<td class="nb"><?= $this->Html->readableDate($v['Callbacks']['created']) ?></td>
			<td class="nb">
				<?php if ($v['Callbacks']['get_news']): ?>
					<span class="fa fa-check color-green"></span>
				<?php else: ?>
					<span class="fa fa-times color-red"></span>
				<?php endif ?>
			</td>
			<td class="nb">
				<?php if ($v['Callbacks']['finished']): ?>
					<?= __d('admin', 'Finished') ?>
				<?php else: ?>
					<?= __d('admin', 'New') ?>
				<?php endif ?>
			</td>
			<td class="nb icons">
				<?php if ($v['Callbacks']['finished']):
					$btn = ['view'];
				else:
					$btn = ['view', 'finished'];
				endif ?>
				<?= $this->element('admin/action-btn', [
					'buttons' => $btn,
					'id' => $v['Callbacks']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?= $this->Form->end() ?>

<?= $this->element('admin/paginator') ?>
