<div class="mobile-slider-container portfolio-slider-container">
	<div class="mobile-slider mobile-slider-arrows">
		<?php foreach ($data as $v): ?>
			<div class="mobile-slide">
				<div class="inner">
					<a href="<?= $this->Html->url(['controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_'.$lang]]) ?>" class="blocks__block">
						<?= $this->Html->uploadedImage('portfolio/'.$v['Portfolio']['filename'], ['class' => 'mobile-image']) ?>
						<div class="bottom_background">
							<h3 class="blocks__title">
								<?= $v['Portfolio']['title_'.$lang] ?>
							</h3>
						</div>
					</a>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>


<div class="mb-md mt-md c">
	<?= $this->Html->link(__('Skatīt visus'), ['controller' => 'portfolio', 'action' => 'index']) ?>
</div>
