<?php $this->set('title_for_layout', $page_title = $data['Industry']['title_'.$lang]) ?>

<?= $this->element('admin/tools') ?>

<div class="container">
	<div class="article-container">
		<article class="article">

			<div class="d-flex align-v mb-md hide-mobile">
				<?= $this->element('breadcrumbs', ['breadcrumbs' => $breadcrumbs]) ?>
			</div>

			<h1>
				<?= $page_title ?>
			</h1>

			<div class="article-body">
				<?= $data['Industry']['description_'.$lang] ?>
			</div>

			<?php if (!empty($articles)): ?>
				<br /><br />

				<h2>
					<?= __('Blogs') ?>
				</h2>

				<?php foreach ($articles as $v): ?>
					<div class="article-body media">
						<?php if ($v['Article']['filename']): ?>
							<div class="img">
								<?= $this->Html->uploadedImage('articles/thumb/'.$v['Article']['filename'], ['width' => Article::$IMAGE_SIZE['filename']['w'], 'height' => Article::$IMAGE_SIZE['filename']['h'], 'alt' => $v['Article']['alt_'.$lang]]) ?>
							</div>
						<?php endif ?>
						<div class="bd">
							<h3>
								<?= $v['Article']['title_'.$lang] ?>
							</h3>
							<p>
								<?= $this->Html->preprocessText($v['Article']['intro_'.$lang]) ?>
							</p>
							<p>
								<?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'articles', 'action' => 'view', $v['Article']['strid_'.$lang]]) ?>
							</p>
						</div>
					</div>
				<?php endforeach ?>
			<?php endif ?>

			<?php if (!empty($products)): ?>
				<br /><br />

				<h2>
					<?= $data['Industry']['products_title_'.$lang] ?>
				</h2>

				<div class="grid">
					<?php foreach ($products as $v): ?>
						<a href="<?= $this->Html->url(['controller' => 'products', 'action' => 'view', $v['Product']['strid_'.$lang], '?' => 'from=industry']) ?>" class="grid-item">
							<?php

							$p = ['width' => Product::$IMAGE_SIZE['filename']['w'], 'height' => Product::$IMAGE_SIZE['filename']['h'], 'alt' => $v['Product']['alt_'.$lang]];

							if ($v['Product']['filename']) {
								echo $this->Html->uploadedImage('products/small/'.$v['Product']['filename'], $p);
							} else {
								echo $this->Html->image('product.png', $p);
							}

							?>
							<span class="title"><?= $v['Product']['title_'.$lang] ?></span>
						</a>
					<?php endforeach ?>
					<div class="grid-item"></div>
					<div class="grid-item"></div>
				</div>
			<?php endif ?>

			<?php if (!empty($portfolio)): ?>
				<br /><br />

				<h2>
					<?= __('Portfolio') ?>
				</h2>

				<div class="rowed-thumbs">
					<?php foreach ($portfolio as $v): ?>
						<a href="<?= $this->Html->url(['controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_'.$lang]]) ?>" class="grid-item">
							<?php

							$p = ['alt' => $v['Portfolio']['alt_'.$lang]];

							if ($v['Portfolio']['filename_wide']) {
								echo $this->Html->uploadedImage('portfolio/wide/'.$v['Portfolio']['filename_wide'], $p);
							} else {
								echo $this->Html->image('portfolio.png', $p);
							}

							?>
							<span class="title"><?= $v['Portfolio']['title_'.$lang] ?></span>
						</a>
					<?php endforeach ?>
				</div>
			<?php endif ?>
		</article>
	</div>

</div>
