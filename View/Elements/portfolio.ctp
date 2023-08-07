<?php

$chunks = array_chunk($data, 4);

?>
<div class="container" id="portfolio">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Portfolio') ?>
			</h2>
			<div class="section-description text-content">
				<?= nl2br($section_headings['portfolio']) ?>
			</div>
		</header>
		<div class="section-content">

			<div class="section-slider-container">
				<div class="section-slider js-section-slider">
					<?php foreach ($chunks as $chunk): ?>
						<div class="section-slide">
							<?php foreach ($chunk as $v): ?>
								<div class="section-brick">
									<div class="section-brick-content">
										<h3>
											<?= $v['Portfolio']['title_'.$lang] ?>
										</h3>
										<div class="section-brick-description text-content">
											<?= nl2br($v['Portfolio']['intro_'.$lang]) ?>
										</div>
										<div>
											<?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_'.$lang]], ['class' => 'button button-block']) ?>
										</div>
									</div>
									<div class="section-brick-image">
										<?php

										if ($v['Portfolio']['filename']) {

											$alt = "alt=\"\"";

											if (!empty($v['Portfolio']['alt_'.$lang])) {
												$alt = "alt=\"".$v['Portfolio']['alt_'.$lang]."\"";
											}

											?>
											<img src="/uploads/images/portfolio/<?= $v['Portfolio']['filename']; ?>" <?= $alt; ?> />
											<?php
										}
										?>
									</div>
								</div>
							<?php endforeach ?>
						</div>
					<?php endforeach ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</section>
</div>
