<?php $this->set('title_for_layout', $page_title = __d('admin', 'Contacts').' » '.__d('admin', 'view')) ?>

<div class="tools">
	<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
		<span class="fa fa-trash"></span>
		<?= __d('admin', 'Delete') ?>
	</a>
</div>

<h2><?= $page_title ?></h2>

<table class="list">
	<tr>
		<th class="nb r"><?= __d('admin', 'Company') ?></th>
		<td><?= h($data['Contacts']['name']) ?></td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'E-mail') ?></th>
		<td><?= h($data['Contacts']['email']) ?: '&mdash;' ?></td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'Phone') ?></th>
		<td><?= h($data['Contacts']['phone']) ?: '&mdash;' ?></td>
	</tr>
	<?php if (!empty($data['Product']['id'])): ?>
		<tr>
			<th class="nb r"><?= __d('admin', 'Product') ?></th>
			<td><?= $this->Html->link($data['Product']['title_'.$lang], ['admin' => false, 'controller' => 'products', 'action' => 'view', $data['Product']['strid_'.$lang]]) ?></td>
		</tr>
	<?php endif ?>
	<tr>
		<th class="nb r"><?= __d('admin', 'Text') ?></th>
		<td><?= nl2br(h($data['Contacts']['text'])) ?></td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'News') ?></th>
		<td>
			<?php if ($data['Contacts']['get_news']): ?>
				<span class="fa fa-check color-green"></span>
			<?php else: ?>
				<span class="fa fa-times color-red"></span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th class="nb r"><?= __d('admin', 'Date') ?></th>
		<td><?= $data['Contacts']['created'] ?></td>
	</tr>
</table>
