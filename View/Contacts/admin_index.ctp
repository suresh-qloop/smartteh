<?php $this->set('title_for_layout', $page_title = __d('admin', 'Contacts')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Contacts', ['inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<tr>
		<th><?= $this->Paginator->sort('name', __d('admin', 'Company')) ?></th>
		<th><?= $this->Paginator->sort('email', __d('admin', 'E-mail')) ?></th>
		<th><?= $this->Paginator->sort('phone', __d('admin', 'Phone')) ?></th>
		<th><?= $this->Paginator->sort('Product.title_'.$lang, __d('admin', 'Product')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('created', __d('admin', 'Date')) ?></th>
		<th><?= $this->Paginator->sort('get_news', __d('admin', 'News')) ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<tr class="search-row">
		<td><?= $this->Form->input('name') ?></td>
		<td><?= $this->Form->input('email') ?></td>
		<td><?= $this->Form->input('phone') ?></td>
		<td><?= $this->Form->input('Product.title_'.$lang) ?></td>
		<td class="nb"><?= $this->Form->input('created', ['class' => 'txt datepicker']) ?></td>
		<td class="nb"><?= $this->element('admin/search-row-submit') ?></td>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr>
			<td><?= h($v['Contacts']['name']) ?></td>
			<td><?= h($v['Contacts']['email']) ?></td>
			<td><?= h($v['Contacts']['phone']) ?></td>
			<td>
				<?php if (!empty($v['Product']['id'])): ?>
					<?= $this->Html->link($v['Product']['title_'.$lang], ['admin' => false, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_'.$lang]]) ?>
				<?php endif ?>
			</td>
			<td class="nb"><?= $this->Html->readableDate($v['Contacts']['created']) ?></td>
			<td class="nb">
				<?php if ($v['Contacts']['get_news']): ?>
					<span class="fa fa-check color-green"></span>
				<?php else: ?>
					<span class="fa fa-times color-red"></span>
				<?php endif ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['view'],
					'id' => $v['Contacts']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?= $this->Form->end() ?>

<?= $this->element('admin/paginator') ?>
