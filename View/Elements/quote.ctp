<?php

if (!$data) {
	return;
}

$class = 'quote-item';

if (!empty($active)) {
	$class .= ' active';
}

?>
<blockquote class="<?= $class ?>">
	<?php

	$p = ['width' => Quote::$IMAGE_SIZE['filename']['w'], 'height' => Quote::$IMAGE_SIZE['filename']['h'], 'class' => 'quote-image'];

	if ($data['Quote']['filename']) {
		echo $this->Html->uploadedImage('quotes/'.$data['Quote']['filename'], $p);
	} else {
		echo $this->Html->image('default-quotes-image.png', $p);
	}

	?>
	<div class="quote-inner">
		<div class="quote-name">
			<?php

			$lines = [$data['Quote']['name']];

			if ($data['Quote']['tagline']) {
				$lines[] = $data['Quote']['tagline'];
			}

			echo implode(', ', $lines);

			?>
		</div>
		<div class="quote-text">
			<?= nl2br($data['Quote']['text']) ?>
		</div>
	</div>
</blockquote>
