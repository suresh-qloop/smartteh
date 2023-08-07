<?php

$chunks = array_chunk($data, 4);

?>
<div class="container" id="blog">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Articles') ?>
			</h2>
			<div class="section-description text-content">
				<?= nl2br($section_headings['articles']) ?>
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
											<?= $v['Article']['title_'.$lang] ?>
										</h3>
										<div class="section-brick-description text-content">
											<?= nl2br($v['Article']['intro_'.$lang]) ?>
										</div>
										<div>
											<?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'articles', 'action' => 'view', $v['Article']['strid_'.$lang]], ['class' => 'button button-block']) ?>
										</div>
									</div>
									<div class="section-brick-image">
										<?php

										if ($v['Article']['filename']) {

											$alt = "alt=\"\"";

											if (!empty($v['Article']['alt_'.$lang])) {
												$alt = "alt=\"".$v['Article']['alt_'.$lang]."\"";
											}

											?>
											<?= $this->Html->uploadedImage('articles/thumb/'.$v['Article']['filename'], ['width' => Article::$IMAGE_SIZE['filename']['w'], 'height' => Article::$IMAGE_SIZE['filename']['h'], 'alt' => $alt]) ?>
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
