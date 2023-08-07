<?php $this->set('title_for_layout', $page_title = __d('admin', 'Portfolio').' » '.__d('admin', 'images')) ?>

<div class="tools">
	<?= $this->element('admin/tabs', ['data' => Portfolio::getAdminTabs($portfolio_id)]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('PortfolioImage', ['url' => ['action' => 'update'], 'class' => 'product-images']) ?>
<table class="list js-gallery">
	<thead>
	<tr>
	<tr>
		<th class="nb">
			<?= __d('admin', 'Image') ?>
		</th>
		<th>
			<?= __d('admin', 'Title') ?>
		</th>
		<th>
			<?= __d('admin', 'Alt') ?>
		</th>
		<th class="nb">
			<?= __d('admin', 'Action') ?>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v): ?>
		<tr>
			<td class="nb">
				<a href="/uploads/images/portfolio/large/<?= $v['PortfolioImage']['filename'] ?>" class="pop">
					<?= $this->Html->uploadedImage('portfolio/preview/'.$v['PortfolioImage']['filename'], ['width' => 123]) ?>
				</a>
			</td>
			<td>
				<?= $this->Form->input('title', [
					'name' => 'data[PortfolioImage]['.$v['PortfolioImage']['id'].'][title_'.$lang.']',
					'value' => $v['PortfolioImage']['title_'.$lang],
					'label' => false
				]) ?>
			</td>
			<td>
				<?= $this->Form->input('alt', [
					'name' => 'data[PortfolioImage]['.$v['PortfolioImage']['id'].'][alt_'.$lang.']',
					'value' => $v['PortfolioImage']['alt_'.$lang],
					'label' => false
				]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['moveup', 'movedown', 'delete'],
					'id' => $v['PortfolioImage']['id']
				]) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>
<?= $this->Form->end(); ?>

<br />

<div>
	<label for="upload-portfolio-items" class="btn btn-w-icon"><span class="fa fa-upload"></span> <?= __d('admin', 'Upload') ?>
	</label>

	<form action="<?= Router::url(['action' => 'upload']) ?>" class="js-gallery-upload">
		<input type="file" multiple="multiple" id="upload-portfolio-items" />
		<input type="hidden" name="portfolio_id" value="<?= $portfolio_id ?>" />
		<input type="hidden" name="response" value="list" />
	</form>
</div>

<?= $this->element('admin/paginator') ?>
