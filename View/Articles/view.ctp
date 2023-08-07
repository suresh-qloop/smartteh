<?php $this->set('title_for_layout', $page_title = $data['Article']['title_'.$lang]) ?>

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

			<div class="article-body media">
				<?php if ($data['Article']['filename']): ?>
					<div class="img">
						<?= $this->Html->uploadedImage('articles/thumb/'.$data['Article']['filename'], ['width' => Article::$IMAGE_SIZE_SMALL['filename']['w'], 'height' => Article::$IMAGE_SIZE_SMALL['filename']['h'], 'alt' => $data['Article']['alt_'.$lang]]) ?>
						<br />
					</div>
				<?php endif ?>
				<div class="bd">
					<?= $this->Html->preprocessText($data['Article']['text_'.$lang]) ?>
				</div>
			</div>

			<p>
				<?= $this->Html->link(__('Atpakaļ uz sākumu'), ['controller' => 'articles', 'action' => 'index'], ['class' => 'dont-track']) ?>
			</p>
		</article>
	</div>

	<?php if ($data['RelatedArticle']): ?>
		<div class="article">
			<h2>
				<?= __('Saistītie raksti') ?>
			</h2>
		</div>

		<?php foreach ($data['RelatedArticle'] as $v): ?>
			<article class="article">
				<div class="article-body media">
					<?php if ($v['filename']): ?>
						<div class="img">
							<?= $this->Html->uploadedImage('articles/thumb/'.$v['filename'], ['width' => Article::$IMAGE_SIZE_SMALL['filename']['w'], 'height' => Article::$IMAGE_SIZE_SMALL['filename']['h'], 'alt' => $v['alt_'.$lang]]) ?>
						</div>
					<?php endif ?>
					<div class="bd">
						<h2>
							<?= $v['title_'.$lang] ?>
						</h2>

						<?= $this->Html->preprocessText($v['intro_'.$lang]) ?>
						<p><?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'articles', 'action' => 'view', $v['strid_'.$lang]]) ?></p>
					</div>
				</div>

			</article>
		<?php endforeach ?>
	<?php endif ?>

</div>
