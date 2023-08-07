<div class="blocks">
	<?php foreach ($data as $v): ?>
		<a href="<?= $this->Html->url(['controller' => 'services', 'action' => 'view', $v['Service']['strid_'.$lang]]) ?>" class="blocks__block w-full">
			<?= $this->Html->uploadedImage('services/mobile/'.$v['Service']['filename_mobile'], ['class' => 'blocks__image']) ?>
			<h3 class="blocks__title service-title">
				<?= $v['Service']['title_'.$lang] ?>
			</h3>
		</a>
	<?php endforeach ?>
</div>
