<div class="blocks">
	<?php foreach ($data as $v): ?>
		<a href="<?= $this->Html->url(['controller' => 'industries', 'action' => 'view', $v['Industry']['strid_'.$lang]]) ?>" class="blocks__block">
			<?= $this->Html->uploadedImage('industries/brick/'.$v['Industry']['filename_brick'], ['class' => 'blocks__image', 'alt' => $v['Industry']['alt_'.$lang]]) ?>
			<h3 class="blocks__title">
				<?= $v['Industry']['title_'.$lang] ?>
			</h3>
		</a>
	<?php endforeach ?>
</div>
