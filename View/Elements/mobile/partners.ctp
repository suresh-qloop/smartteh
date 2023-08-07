<?php

$chunks = array_chunk($data, 2);

?>
<div class="partners-slider-container">
	<div class="partners-slider js-slider--partners">
		<?php foreach ($chunks as $chunk): ?>
			<div class="partner-slide">
				<div class="row">
					<?php foreach ($chunk as $v): ?>
						<div class="inner">
							<?php

							if ($v['Partner']['description_'.$lang]) {
								$description = '<div class="description">'.nl2br($v['Partner']['description_'.$lang]).'</div>';
							} else {
								$description = '';
							}

							$html = '
                                <div class="partner-image">
                                    '.$this->Html->uploadedImage('partners/'.$v['Partner']['filename'], ['alt' => $v['Partner']['title'], 'class' => 'partner-logo']).'
                                </div>
                                <div class="partner-info">
                                    <div class="title">'.$v['Partner']['title'].'</div>
                                    '.$description.'
                                </div>
                            ';

							if (!empty($v['Partner']['url'])) {
								$options = ['escape' => false, 'class' => 'item'];
								if ($v['Partner']['new_window']) {
									$options['target'] = '_blank';
								}
								echo $this->Html->link($html, $v['Partner']['url'], $options);
							} else {
								echo '<div class="item">'.$html.'</div>';
							}

							?>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<div class="clear"></div>
	<div class="section-btn">
		<button class="button btn-more" data-more="<?= __('Rādīt vairāk') ?>" data-less="<?= __('Rādīt mazāk') ?>"><?= __('Rādīt vairāk') ?></button>
	</div>
</div>
