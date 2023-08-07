<?php $this->set('title_for_layout', $page_title = __d('admin', 'Administrators')) ?>

<div class="tools">
	<?php if ($this->Session->read('Admin.root')): ?>
		<?= $this->element('admin/add-btn') ?>
	<?php endif ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Admin', ['inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<thead>
	<tr>
		<th><?= $this->Paginator->sort('name', __d('admin', 'Name')) ?></th>
		<th><?= $this->Paginator->sort('username', __d('admin', 'Username')) ?></th>
		<th><?= $this->Paginator->sort('email', __d('admin', 'E-mail')) ?></th>
		<th class="nb"><?= $this->Paginator->sort('created', __d('admin', 'Created')) ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<tr class="search-row">
		<td><?= $this->Form->input('name') ?></td>
		<td><?= $this->Form->input('username') ?></td>
		<td><?= $this->Form->input('email') ?></td>
		<td class="nb"><?= $this->Form->input('created', ['class' => 'txt datepicker']) ?></td>
		<td class="nb"><?= $this->element('admin/search-row-submit') ?></td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v): ?>
		<tr>
			<td><?= $v['Admin']['name'] ?></td>
			<td><?= $v['Admin']['username'] ?></td>
			<td><?= $v['Admin']['email'] ?></td>
			<td class="nb"><?= $this->Html->readableDate($v['Admin']['created']) ?></td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['update'],
					'id' => $v['Admin']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?= $this->Form->end() ?>

<?= $this->element('admin/paginator') ?>
