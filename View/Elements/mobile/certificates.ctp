<?php
$chunks = array_chunk($data, 2);
?>
<div class="partners-slider-container">
	<div class="partners-slider js-slider">
		<?php foreach ($chunks as $chunk): ?>
			<div class="certificate_list">
				<div class="row">
					<?php foreach ($chunk as $v): ?>
						<div class="item">
							<?php
							$img = '<div class="image">'.$this->Html->uploadedImage('certificates/'.$v['Certificate']['filename'], ['alt' => $v['Certificate']['title_'.$lang]]).'</div>';

							$title = '<p>'.$v['Certificate']['title_'.$lang].'</p>';

							$content = $img.'<div class="title">'.$title.'</div>';

							echo $this->Html->link($content, $this->webroot.'uploads/images/certificates/original/'.$v['Certificate']['filename'], ['escape' => false, 'data-fslightbox' => 'gallery', 'full_base' => true]);
							?>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>
