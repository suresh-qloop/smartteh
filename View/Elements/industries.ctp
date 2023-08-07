<div class="container" id="industries">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Industrijas') ?>
			</h2>
			<div class="section-description text-content">
				<?= nl2br($section_headings['industries']) ?>
			</div>
		</header>
		<div class="section-content section-bricks">

			<?php foreach ($data as $v): ?>
				<div class="section-brick">
					<div class="section-brick-content">
						<h3>
							<?= $v['Industry']['title_'.$lang] ?>
						</h3>
						<div class="section-brick-description text-content">
							<?= nl2br($v['Industry']['intro_'.$lang]) ?>
						</div>
						<div>
							<?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'industries', 'action' => 'view', $v['Industry']['strid_'.$lang]], ['class' => 'button button-block']) ?>
						</div>
					</div>
					<div class="section-brick-image">
						<?php

						if ($v['Industry']['filename_brick']) {

							$alt = "alt=\"\"";

							if (!empty($v['Industry']['alt_'.$lang])) {
								$alt = "alt=\"".$v['Industry']['alt_'.$lang]."\"";
							}

							?>
							<img src="/uploads/images/industries/brick/<?= $v['Industry']['filename_brick']; ?>" <?= $alt; ?> />
							<?php
						}
						?>
					</div>
				</div>
			<?php endforeach ?>

		</div>
	</section>
</div>
