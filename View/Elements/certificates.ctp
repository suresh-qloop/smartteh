<div class="container" id="certificates">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Sertifikāti') ?>
			</h2>
			<?php if (isset($section_headings['certificates'])): ?>
				<div class="section-description text-content">
					<?= nl2br($section_headings['certificates']) ?>
				</div>
			<?php endif; ?>
		</header>
		<div class="section-content certificate_list">
			<?php foreach ($data as $v): ?>
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
	</section>
</div>
