<?php

$chunks = array_chunk($data, 8);

?>
<div class="container" id="partners">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Partneri') ?>
			</h2>
			<div class="section-description text-content">
				<?= nl2br($section_headings['partners']) ?>
			</div>
		</header>
		<div class="section-content section-content--partners">
			<div class="section-slider-container partners-slider-container">
				<div class="section-slider js-section-slider--partners"><!---->
					<?php foreach ($chunks as $chunk): ?>
						<div class="section-slide partner-slide">
							<?php
							$rows = array_chunk($chunk, 4);
							?>
							<?php foreach ($rows as $row): ?>
								<div class="row">
									<?php foreach ($row as $v): ?>
										<div class="item">
											<?php

											$title = '<h3>'.$v['Partner']['title'].'</h3>';

											$description = '<div>'.$v['Partner']['description_'.$lang].'</div>';

											$img = '<div class="image">'.$this->Html->uploadedImage('partners/'.$v['Partner']['filename'], ['alt' => $v['Partner']['title']]).'</div>';

											$content = '<div class="info">'.$title.$description.'</div>'.$img;

											if (!empty($v['Partner']['url'])) {
												$options = ['escape' => false, 'class' => 'dont-track'];
												if ($v['Partner']['new_window']) {
													$options['target'] = '_blank';
												}
												echo $this->Html->link($content, $v['Partner']['url'], $options);
											} else {
												echo $content;
											}

											?>
										</div>
									<?php endforeach ?>
								</div>
								<div class="clear"></div>
							<?php endforeach ?>
						</div>
					<?php endforeach ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="section-btn">
				<button class="button btn-more" data-more="<?= __('Rādīt vairāk') ?>" data-less="<?= __('Rādīt mazāk') ?>"><?= __('Rādīt vairāk') ?></button>
			</div>
		</div>
	</section>
</div>
