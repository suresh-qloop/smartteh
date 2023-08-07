<?php $this->set('title_for_layout', $page_title = __d('admin', 'Tracking')) ?>
<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Tracking', ['url' => ['controller' => 'tracking', 'action' => 'imagestats'], 'inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<tr>
		<td><?= __d('admin', 'Date range') ?> </td>
	</tr>
	<tr class="search-row">
		<td class="nb">
			<div style="width: 50%">
				<?= $this->Form->input('start_date', ['class' => 'txt datepicker', 'style' => 'width:45%', 'default' => date('Y-m-d', strtotime('-30 days'))]) ?>
				-
				<?= $this->Form->input('end_date', ['class' => 'txt datepicker', 'style' => 'width:45%', 'default' => date('Y-m-d')]) ?>
				<?= $this->element('admin/search-row-submit') ?>
			</div>
		</td>
	</tr>
</table>
<?= $this->Form->end() ?>
<table class="list">
	<tr>
		<th><?= __d('admin', 'Image') ?></th>
		<th><?= __d('admin', 'From (URL)') ?></th>
		<th><?= __d('admin', 'To (URL)') ?></th>
		<th><?= __d('admin', 'ALT (Image)') ?></th>
		<th><?= $this->Paginator->sort('summedViews', __d('admin', 'Views')) ?></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr>
			<td>
				<img src="<?= $v['Tracking']['img'] ?>" style="width: 50px; height: auto"  alt=""/>
			</td>
			<td>
				<a href="<?= $v['Tracking']['place'] ?>" target="_blank"><?= $v['Tracking']['place'] ?></a>
			</td>
			<td>
				<a href="<?= $v['Tracking']['url'] ?>" target="_blank"><?= $v['Tracking']['url'] ?></a>
			</td>
			<td>
				<?= $v['Tracking']['img_alt'] ?>
			</td>
			<td>
				<?= $v['Tracking']['summedViews'] ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
<?= $this->element('admin/paginator') ?>
