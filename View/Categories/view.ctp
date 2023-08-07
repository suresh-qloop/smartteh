<?php $this->set('title_for_layout', $page_title = $data['Category']['title_'.$lang]) ?>
<?php $title = (isset($data['Category']['products_title_'.$lang]) ? $data['Category']['products_title_'.$lang] : ''); ?>

<?= $this->element('admin/tools') ?>

<div class="container">
	<div class="article-container">
		<?php echo $this->element('sidebar-categories', ['data' => $menu_categories, 'active_id' => $data['Category']['id']]) ?>

		<article class="article">
			<div class="d-flex align-v mb-md hide-mobile">
				<?= $this->element('breadcrumbs', ['breadcrumbs' => $breadcrumbs]) ?>
			</div>
			<h1>
				<?= $page_title ?>
			</h1>
			<?= $this->element('mobile/products', ['products' => $products]) ?>
			<div class="article-body">
				<?= $data['Category']['description_'.$lang] ?>
			</div>
			<?php if (!empty($subcategories)): ?>
				<br /><br />
				<h2>
					<?= $data['Category']['category_title_'.$lang] ?>
				</h2>
				<div class="<?= $data['Category']['big_thumbnails'] ? 'rowed-thumbs' : 'grid' ?>">
					<?php
					$path = 'categories'.($data['Category']['big_thumbnails'] ? '/big' : '');
					?>
					<?php foreach ($subcategories as $v): ?>
						<a href="<?= $this->Html->url(['action' => 'view', $v['Category']['strid_'.$lang]]) ?>" class="grid-item">
							<?php
							$p = ['width' => Category::$IMAGE_SIZE['filename']['w'], 'height' => Category::$IMAGE_SIZE['filename']['h']];
							if ($v['Category']['filename']) {
								echo $this->Html->uploadedImage($path.'/'.$v['Category']['filename'], $p);
							} else {
								echo $this->Html->image('category.png', $p);
							}
							?>
							<span class="title"><?= $v['Category']['title_'.$lang] ?></span>
						</a>
					<?php endforeach ?>
					<div class="grid-item"></div>
					<div class="grid-item"></div>
				</div>
			<?php endif ?>
		</article>
	</div>
</div>
<style>
	.slick-slider-container {
		padding-left: 10px;
		width: 100%;
		max-width: calc(980px - (980px * 0.25) - 50px) !important;
	}

	@media only screen and (min-width: 1600px) {
		.slick-slider-container {
			max-width: calc(1620px - (1620px * 0.25) - 50px) !important;
		}
	}
</style>
