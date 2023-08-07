<?php $this->set('title_for_layout', $page_title = __d('admin', 'Callbacks').' » '.__d('admin', 'view')) ?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>
</div>

<h2><?= $page_title ?></h2>

<table class="list">
	<tr>
		<th class="nb r"><?= __d('admin', 'Name') ?></th>
		<td><?= h($data['Callbacks']['name']) ?></td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'Company') ?></th>
		<td><?= h($data['Callbacks']['company']) ?></td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'E-mail') ?></th>
		<td><?= h($data['Callbacks']['email']) ?: '&mdash;' ?></td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'Phone') ?></th>
		<td><?= h($data['Callbacks']['phone']) ?: '&mdash;' ?></td>
	</tr>
	<?php if (!empty($data['Product']['id'])): ?>
		<tr>
			<th class="nb r"><?= __d('admin', 'Product') ?></th>
			<td><?= $this->Html->link($data['Product']['title_'.$lang], ['admin' => false, 'controller' => 'products', 'action' => 'view', $data['Product']['strid_'.$lang]]) ?></td>
		</tr>
	<?php endif ?>
	<tr>
		<th class="nb r"><?= __d('admin', 'Question') ?></th>
		<td><?= nl2br(h($data['Callbacks']['question'])) ?></td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'News') ?></th>
		<td>
			<?php if ($data['Callbacks']['get_news']): ?>
				<span class="fa fa-check color-green"></span>
			<?php else: ?>
				<span class="fa fa-times color-red"></span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'Status') ?></th>
		<td>
			<?php if ($data['Callbacks']['finished']): ?>
				<?= __d('admin', 'Finished') ?>
			<?php else: ?>
				<?= __d('admin', 'New') ?>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'Date') ?></th>
		<td><?= $data['Callbacks']['created'] ?></td>
	</tr>
</table>
