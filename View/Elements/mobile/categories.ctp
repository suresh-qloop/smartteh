<div class="mobile-slider-container">
	<div class="mobile-slider mobile-slider-static-pagination">
		<?php foreach ($data as $v): ?>
			<div class="mobile-slide">
				<div class="inner">
					<a href="<?= $this->Html->url(['controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$lang]]) ?>" class="blocks__block">
						<?= $this->Html->uploadedImage('categories/menu/'.$v['Category']['filename_menu'], ['class' => 'mobile-image big-image']) ?>
						<div class="bottom_background">
							<h3 class="blocks__title">
								<?= $v['Category']['title_'.$lang] ?>
							</h3>
						</div>
					</a>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>

