<div class="blocks green-grid show-on-mobile">
	<?php if (!empty($products)): ?>
		<?php foreach ($products as $v): ?>
			<a href="<?= $this->Html->url(['controller' => 'products', 'action' => 'view', $v['Product']['strid_'.$lang], '?' => 'from=category']) ?>" class="blocks__block p-xs">
				<?php
				if ($v['Product']['filename']) {
					echo $this->Html->uploadedImage('products/large/'.$v['Product']['filename'], ['class' => 'blocks__image']);
				} else {
					echo $this->Html->image('product.png');
				}
				?>
			</a>
		<?php endforeach ?>
	<?php endif ?>
</div>
