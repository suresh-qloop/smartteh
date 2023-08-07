<?php $this->set('title_for_layout', $page_title = $data['Product']['title_'.$lang]) ?>

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

				<div class="product-images-block js-gallery">
					<?php if ($data['Product']['filename']): ?>
						<div class="product-image">
							<a href="<?= Router::url('/uploads/images/products/large/'.$data['Product']['filename']) ?>" class="pop zoom dont-track" rel="gallery">
								<?= $this->Html->uploadedImage('products/large/'.$data['Product']['filename'], ['width' => 241, 'height' => 241, 'alt' => $data['Product']['alt_'.$lang]]) ?>
							</a>
						</div>
					<?php endif ?>

					<?php if ($data['ProductImage']): ?>
						<div class="product-images">
							<?php foreach ($data['ProductImage'] as $v): ?>
								<a href="<?= Router::url('/uploads/images/products/large/'.$v['filename']) ?>" class="pop dont-track" title="<?= $v['title_'.$lang] ?>" rel="gallery">
									<?= $this->Html->uploadedImage('products/medium/'.$v['filename'], ['width' => 55, 'height' => 55, 'alt' => $v['alt_'.$lang]]) ?>
								</a>
							<?php endforeach ?>
						</div>
					<?php endif ?>
				</div>

				<?php if ($data['Product']['manufacturer']): ?>
					<div class="product-description-block">
						<b><?= __('Ražotājs:') ?></b>
						<?= $data['Product']['manufacturer'] ?>
					</div>
				<?php endif ?>

				<div class="product-description-block">
					<div><b><?= __('Apraksts:') ?></b></div>
					<?= $data['Product']['description_'.$lang] ?>
				</div>

				<?php if ($data['Product']['show_contact_form']): ?>
					<div class="no-print">
						<h2>
							<?= __('Jautājumi?') ?>
						</h2>
						<?= $this->element('contacts', ['product_id' => $data['Product']['id'], 'show_phone' => true]) ?>
					</div>
				<?php endif ?>

			</div>

		</article>
	</div>
</div>
