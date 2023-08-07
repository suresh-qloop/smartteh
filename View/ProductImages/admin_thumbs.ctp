<?php $this->set('title_for_layout', $page_title = __d('admin', 'Products').' » '.__d('admin', 'images')) ?>

<div class="tools">
	<?= $this->element('admin/tabs', ['data' => Product::getAdminTabs($product_id)]) ?>
</div>

<div class="tools">
	<label for="upload-product-items" class="btn btn-w-icon"><span class="fa fa-upload"></span> <?= __d('admin', 'Upload') ?>
	</label>

	<form action="<?= Router::url(['action' => 'upload']) ?>" class="js-gallery-upload">
		<input type="file" multiple="multiple" id="upload-product-items" />
		<input type="hidden" name="product_id" value="<?= $product_id ?>" />
		<input type="hidden" name="response" value="thumbs" />
	</form>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('ProductImage', ['url' => ['action' => 'delete'], 'class' => 'confirm']) ?>

<ul class="gallery-items js-gallery" data-sortable="<?= Router::url('/admin/product_images/sort_images/') ?>">
	<?php foreach ($data as $v): ?>
		<li data-id="<?= $v['ProductImage']['id'] ?>">
			<a href="/uploads/images/products/large/<?= $v['ProductImage']['filename'] ?>" class="pop">
				<?= $this->Html->uploadedImage('products/preview/'.$v['ProductImage']['filename'], ['width' => 123]) ?>
			</a>

			<div class="toolbar">
				<?= $this->Form->input('id.'.$v['ProductImage']['id'], ['type' => 'checkbox', 'label' => '', 'div' => 'input checkbox no-label']) ?>
				<?= $this->Html->link('', ['controller' => 'product_images', 'action' => 'delete', $v['ProductImage']['id']], ['class' => 'fa fa-trash-o confirm', 'title' => __d('admin', 'edit')]) ?>
			</div>
		</li>
	<?php endforeach ?>
</ul>

<div class="submit">
	<?= $this->Form->submit(__d('admin', 'Delete selected'), [
		'div' => false
	]) ?>
	&nbsp;<a href="#" onclick="checkAll('.gallery-items'); return false"><?= __d('admin', 'select all') ?></a>
	&nbsp;/&nbsp;<a href="#" onclick="uncheckAll('.product-items'); return false"><?= __d('admin', 'deselect all') ?></a>
</div>

<?= $this->Form->end() ?>
