<?php $this->set('title_for_layout', $page_title = $data['Section']['title_'.$lang]) ?>

<?= $this->element('admin/tools') ?>

<div class="container">
	<div class="article-container">
		<article class="article">
			<h1>
				<?= $page_title ?>
			</h1>

			<div class="article-body">
				<?= $this->Html->preprocessText($data['Section']['text_'.$lang]) ?>
			</div>
		</article>
	</div>
</div>
