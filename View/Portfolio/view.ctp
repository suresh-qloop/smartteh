<?php $this->set('title_for_layout', $page_title = $data['Portfolio']['title_'.$lang]) ?>

<?= $this->element('admin/tools') ?>

<div class="container">
	<div class="article-container">
		<article class="article">
			<h1>
				<?= __('Portfolio') ?> / <?= $page_title ?>
			</h1>

			<div class="article-body">
				<?= $this->Html->preprocessText($data['Portfolio']['text_'.$lang]) ?>
			</div>

			<?php if ($data['PortfolioImage']): ?>
				<h2><?= __('Galerija') ?></h2>
				<div class="gallery-images js-gallery">
					<?php foreach ($data['PortfolioImage'] as $v): ?>
						<a href="<?= Router::url('/uploads/images/portfolio/large/'.$v['filename']) ?>" class="pop dont-track" title="<?= $v['title_'.$lang] ?>" rel="gallery">
							<?= $this->Html->uploadedImage('portfolio/medium/'.$v['filename'], ['width' => 165, 'height' => 165, 'alt' => $v['alt_'.$lang]]) ?>
						</a>
					<?php endforeach ?>
				</div>
			<?php endif ?>

			<p>
				<?= $this->Html->link(__('Atpakaļ uz sākumu'), ['controller' => 'start', 'action' => 'index'], ['class' => 'dont-track']) ?>
			</p>
		</article>
	</div>
</div>
