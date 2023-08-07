<?php $this->set('title_for_layout', $page_title = __d('admin', 'Products').' » '.__d('admin', 'images')) ?>

<div class="tools">
	<?= $this->element('admin/tabs', ['data' => Product::getAdminTabs($product_id)]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('ProductImage', ['url' => ['action' => 'update'], 'class' => 'product-images']) ?>
<table class="list js-gallery">
	<thead>
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
				<a href="/uploads/images/products/large/<?= $v['ProductImage']['filename'] ?>" class="pop">
					<?= $this->Html->uploadedImage('products/preview/'.$v['ProductImage']['filename'], ['width' => 123]) ?>
				</a>
			</td>
			<td>
				<?= $this->Form->input('title', [
					'name' => 'data[ProductImage]['.$v['ProductImage']['id'].'][title_'.$lang.']',
					'value' => $v['ProductImage']['title_'.$lang],
					'label' => false
				]) ?>
			</td>
			<td>
				<?= $this->Form->input('alt', [
					'name' => 'data[ProductImage]['.$v['ProductImage']['id'].'][alt_'.$lang.']',
					'value' => $v['ProductImage']['alt_'.$lang],
					'label' => false
				]) ?>
			</td>
			<td class="nb icons">
				<?= $this->element('admin/action-btn', [
					'buttons' => ['moveup', 'movedown', 'delete'],
					'id' => $v['ProductImage']['id']
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
	<label for="upload-product-items" class="btn btn-w-icon"><span class="fa fa-upload"></span> <?= __d('admin', 'Upload') ?>
	</label>

	<form action="<?= Router::url(['action' => 'upload']) ?>" class="js-gallery-upload">
		<input type="file" multiple="multiple" id="upload-product-items" />
		<input type="hidden" name="product_id" value="<?= $product_id ?>" />
		<input type="hidden" name="response" value="list" />
	</form>
</div>

<?= $this->element('admin/paginator') ?>
