<?php if ($response == 'list'): ?>
	<tr>
		<td class="nb">
			<a href="/uploads/images/products/large/<?= $data['ProductImage']['filename'] ?>" class="pop">
				<?= $this->Html->uploadedImage('products/preview/'.$data['ProductImage']['filename'], ['width' => 123]) ?>
			</a>
		</td>
		<td>
			<?= $this->Form->input('title', [
				'name' => 'data[ProductImage]['.$data['ProductImage']['id'].'][title_'.$lang.']',
				'value' => $data['ProductImage']['title_'.$lang],
				'label' => false
			]) ?>
		</td>
		<td>
			<?= $this->Form->input('alt', [
				'name' => 'data[ProductImage]['.$data['ProductImage']['id'].'][alt_'.$lang.']',
				'value' => $data['ProductImage']['alt_'.$lang],
				'label' => false
			]) ?>
		</td>
		<td class="nb icons">
			<?= $this->element('admin/action-btn', [
				'buttons' => ['moveup', 'movedown', 'delete'],
				'id' => $data['ProductImage']['id']
			]) ?>
		</td>
	</tr>
<?php else: ?>
	<li data-id="<?= $data['ProductImage']['id'] ?>">
		<a href="/uploads/images/products/large/<?= $data['ProductImage']['filename'] ?>" class="pop">
			<?= $this->Html->uploadedImage('products/preview/'.$data['ProductImage']['filename'], ['width' => 123]) ?>
		</a>

		<div class="toolbar">
			<?= $this->Form->input('id.'.$data['ProductImage']['id'], ['type' => 'checkbox', 'label' => '', 'div' => 'input checkbox no-label']) ?>
			<?= $this->Html->link('', ['controller' => 'product_images', 'action' => 'delete', $data['ProductImage']['id']], ['class' => 'fa fa-trash-o confirm', 'title' => __d('admin', 'delete')]) ?>
		</div>
	</li>
<?php endif ?>
