<?php

if (!$data) {
	return;
}

?>
<blockquote class="quote">
	<div class="author">
		<?php

		if ($data['Quote']['filename']) {
			echo $this->Html->uploadedImage('quotes/'.$data['Quote']['filename'], ['width' => Quote::$IMAGE_SIZE['filename']['w'], 'height' => Quote::$IMAGE_SIZE['filename']['h'], 'class' => 'thumb']);
		}

		?>
		<div class="name">
			<?php

			$lines = [$data['Quote']['name']];

			if ($data['Quote']['tagline']) {
				$lines[] = $data['Quote']['tagline'];
			}

			echo implode('<br />', $lines);

			?>
		</div>
	</div>
	<p><?= nl2br($data['Quote']['text']) ?></p>
</blockquote>
