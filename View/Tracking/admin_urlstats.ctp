<?php $this->set('title_for_layout', $page_title = __d('admin', 'Tracking')) ?>
<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<?= $this->Form->create('Tracking', ['url' => ['controller' => 'tracking', 'action' => 'urlstats'], 'inputDefaults' => ['type' => 'text', 'label' => false, 'div' => false, 'required' => false, 'class' => 'txt']]) ?>
<table class="list">
	<tr>
		<td><?= __d('admin', 'Date range') ?> </td>
	</tr>
	<tr class="search-row">
		<td class="nb">
			<div style="width: 50%">
				<?= $this->Form->input('start_date', ['class' => 'txt datepicker', 'style' => 'width:45%', 'default' => date('Y-m-d', strtotime('-30 days'))]) ?>
				-
				<?= $this->Form->input('end_date',
					['class' => 'txt datepicker', 'style' => 'width:45%', 'default' => date('Y-m-d')]) ?>
				<?= $this->element('admin/search-row-submit') ?>
			</div>
		</td>
	</tr>
</table>
<?= $this->Form->end() ?>
<table class="list">
	<tr>
		<th><?= __d('admin', 'Links') ?></th>
		<th><?= $this->Paginator->sort('summedViews', __d('admin', 'Views')) ?></th>
		<th><?= $this->Paginator->sort('summedForms', __d('admin', 'Requests')) ?></th>
		<th><?= $this->Paginator->sort('summedPDF', __d('admin', 'PDF download')) ?></th>
		<th><?= __d('admin', 'Meta title') ?></th>
		<th><?= __d('admin', 'Meta description') ?></th>
		<th><?= __d('admin', 'Trend') ?></th>
		<th><?= __d('admin', 'Images') ?></th>
		<th><?= __d('admin', 'Actions') ?></th>
	</tr>
	<tr>
		<th></th>
		<th><?= $all_views ?></th>
		<th><?= $all_form_submits ?></th>
		<th><?= $all_pdf_downloads ?></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr>
			<td>
				<a href="<?= $v['Tracking']['url'] ?>" target="_blank"><?= $v['Tracking']['url'] ?></a>
			</td>
			<td>
				<?= $v['Tracking']['summedViews'] ?>
			</td>
			<td>
				<?= $v['Tracking']['summedForms'] ?>
			</td>
			<td>
				<?= $v['Tracking']['summedPDF'] ?>
			</td>
			<td>
				<?= trim($v['Tracking']['meta_title'], '\'') ?>
			</td>
			<td>
				<?= trim($v['Tracking']['meta_description'], '\'') ?>
			</td>
			<td>
				<?= $v['Tracking']['summedViews'] > $v['Tracking']['previous_views'] ? '<i class="fa fa-fw fa-arrow-up" style="color: #009e00"></i>' :
					($v['Tracking']['summedViews'] < $v['Tracking']['previous_views'] ? '<i class="fa fa-fw fa-arrow-down" style="color: red"></i>' : '-') ?>
			</td>
			<td>
				<?= $v['Tracking']['img_count'] ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['update'],
					'controller' => $v['Tracking']['controller'],
					'id' => $v['Tracking']['url_id']
				]) ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
<?= $this->element('admin/paginator') ?>
