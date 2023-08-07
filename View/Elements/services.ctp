<div class="container" id="services">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Pakalpojumi') ?>
			</h2>
			<div class="section-description text-content">
				<?= nl2br($section_headings['services']) ?>
			</div>
		</header>
		<div class="section-content section-bricks">

			<?php foreach ($data as $v): ?>
				<div class="section-brick h-230 bh-300">
					<div class="section-brick-image">
						<?php

						if ($v['Service']['filename_brick']) {
							?>
							<img src="/uploads/images/services/brick/<?= $v['Service']['filename_brick']; ?>" />
							<?php
						}
						?>
					</div>
				</div>
				<div class="section-brick h-230 bh-300">
					<div class="w-full section-brick-content">
						<h3>
							<?= $v['Service']['title_'.$lang] ?>
						</h3>
						<div class="section-brick-description text-content">
							<?= nl2br($v['Service']['intro_'.$lang]) ?>
						</div>
						<div>
							<?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'services', 'action' => 'view', $v['Service']['strid_'.$lang]], ['class' => 'w-6/12 button button-block']) ?>
						</div>
					</div>
					<div class="section-brick-image">
						<?php

						if ($v['Service']['filename_brick']) {
							?>
							<img src="/uploads/images/services/brick/<?= $v['Service']['filename_brick']; ?>" />
							<?php
						}
						?>
					</div>
				</div>
			<?php endforeach ?>

		</div>
	</section>
</div>
