<?php $this->set('title_for_layout', $page_title = __d('admin', 'Section headings')) ?>

<div class="tools">
	<?= $this->element('admin/add-btn') ?>
</div>

<h2><?= $page_title ?></h2>

<table class="list">
	<thead>
	<tr>
		<th><?= __d('admin', 'Title') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v): ?>
		<tr>
			<td><?= $v['SectionHeading']['title'] ?></td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['update'],
					'id' => $v['SectionHeading']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>

<?= $this->element('admin/paginator') ?>
