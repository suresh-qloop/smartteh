<?php
/* @var array $theme_list */
/* @var int $active */

$this->set('title_for_layout', $page_title = __('Blogs'))

?>

<div class="container">
	<?php if ($theme_list): ?>
	<div class="article-container">
		<?php echo $this->element('sidebar-themes', ['data' => $theme_list, 'active' => $active]) ?>
		<div class="blocks green-grid show-on-mobile blog-themes">
			<div>
				<h2>
					<?= __('Tēmas') ?>
				</h2>
				<button id="theme-btn"><?= __('Rādīt visas') ?></button>
			</div>

			<ul id="theme-list">
				<?php foreach ($theme_list as $v): ?>
					<li class="<?php echo $v['Theme']['id'] == $active ? 'active' : '' ?>">
						<?php echo $this->Html->link($v['Theme']['title_'.$lang], ['controller' => 'articles', 'action' => 'index', $v['Theme']['strid_'.$lang]]); ?>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php endif ?>
		<?php if (!$data): ?>
			<article class="article">
				<div class="article-body">
					<?= __('Neviens ieraksts vēl nav pievienots') ?>
				</div>
			</article>
		<?php endif ?>
		<div style="display: block">
			<?php foreach ($data as $v): ?>
				<article class="article">
					<div class="article-body media">
						<?php if ($v['Article']['filename']): ?>
							<div class="img mr-0">
								<?= $this->Html->uploadedImage('articles/thumb/'.$v['Article']['filename'], ['width' => Article::$IMAGE_SIZE_SMALL['filename']['w'], 'height' => Article::$IMAGE_SIZE_SMALL['filename']['h'], 'alt' => $v['Article']['alt_'.$lang]]) ?>
							</div>
						<?php endif ?>
						<div class="bd">
							<h2>
								<?= $v['Article']['title_'.$lang] ?>
							</h2>
							<p>
								<?= $this->Html->preprocessText($v['Article']['intro_'.$lang]) ?>
							</p>
							<p>
								<?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'articles', 'action' => 'view', $v['Article']['strid_'.$lang]]) ?>
							</p>
						</div>
					</div>

				</article>
			<?php endforeach ?>

		</div>


		<?php if ($theme_list): ?>
	</div>
<?php endif ?>
	<?= $this->element('paginator') ?>
</div>
