<?php $this->set('title_for_layout', $page_title = $data['Product']['title_'.$lang]) ?>

<div class="header">
	<?= $this->Html->image('logo.png', ['width' => 190, 'height' => 70, 'class' => 'header-logo', 'fullBase' => true]) ?>
</div>

<article class="article">
	<h1>
		<?= $page_title ?>
	</h1>

	<div class="article-body">

		<div class="product-image-preview">
			<?php if ($data['Product']['filename']): ?>
				<?= $this->Html->uploadedImage('products/medium/'.$data['Product']['filename'], ['width' => 241, 'height' => 241, 'fullBase' => true]) ?>
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

	</div>

</article>

<?php if ($data['Product']['filename'] || $data['ProductImage']): ?>
	<h2><?= __('Bildes') ?></h2>

	<div class="product-images">
		<?php if ($data['Product']['filename']): ?>
			<div class="product-image">
				<?= $this->Html->uploadedImage('products/large/'.$data['Product']['filename'], ['fullBase' => true]) ?>
			</div>
		<?php endif ?>

		<?php if ($data['ProductImage']): ?>
			<?php foreach ($data['ProductImage'] as $v): ?>
				<div class="product-image">
					<?= $this->Html->uploadedImage('products/large/'.$v['filename'], ['fullBase' => true]) ?>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>
<?php endif ?>
