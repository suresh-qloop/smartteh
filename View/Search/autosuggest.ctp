<div class="as-container">
	<div class="as-products-col">
		<h3><?= __('Iekārtas') ?></h3>

		<?php if ($products): ?>
			<div class="as-products">
				<?php foreach ($products as $v): ?>
					<a class="as-product" href="<?= $this->Html->url(['controller' => 'products', 'action' => 'view', $v['Product']['strid_'.$lang]]) ?>">
						<?php

						$p = ['width' => 45, 'height' => 45, 'class' => 'img'];

						if ($v['Product']['filename']) {
							echo $this->Html->uploadedImage('products/small/'.$v['Product']['filename'], $p);
						} else {
							echo $this->Html->image('product.png', $p);
						}

						?>
						<span class="title">
							<?= $v['Product']['title_'.$lang] ?>
						</span>
					</a>
				<?php endforeach ?>
			</div>
		<?php else: ?>
			<p class="as-not-found"><?= __('Nav rezultātu') ?></p>
		<?php endif ?>
	</div>

	<div class="as-articles-col">
		<h3><?= __('Portfolio') ?></h3>

		<?php if ($portfolio): ?>
			<?php foreach ($portfolio as $v): ?>
				<div class="as-article">
					<?= $this->Html->link($v['Portfolio']['title_'.$lang], ['controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_'.$lang]]) ?>
				</div>
			<?php endforeach ?>
		<?php else: ?>
			<p class="as-not-found"><?= __('Nav rezultātu') ?></p>
		<?php endif ?>
	</div>
</div>
