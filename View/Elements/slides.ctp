<?php

if (empty($slides)) {
	return;
}

?>
<div class="slides">
	<div class="slides-container">
		<?php

		$first = true;

		foreach ($slides

		as $v):

		if ($first) {
			$tag = 'h1';
			$first = false;
		} else {
			$tag = 'span';
		}

		?>
		<div class="item">
			<?php

			if (!empty($v['Slide']['url'])) {

			$target = "";

			if ($v['Slide']['new_window']) {
				$target = "target=\"_blank\"";
			}

			?>
			<a href="<?= $v['Slide']['url']; ?>" <?= $target; ?>>
				<?php

				}

				?>
				<div class="heading white">

					<<?= $tag; ?> class="title">
					<?= $v['Slide']['title']; ?>
				</<?= $tag; ?>>

				<?php

				if (!empty($v['Slide']['url'])) {
					$options = ['escape' => false, 'class' => 'button button-block'];
					if ($v['Slide']['new_window']) {
						$options['target'] = '_blank';
					}

					echo $this->Html->link(__('Lasīt vairāk'), $v['Slide']['url'], $options);
				}

				?>

				<?php

				if (!empty($v['Slide']['url'])) {
				?>
			</a>
		<?php
		}

		?>

		</div>

	</div>
	<?php endforeach ?>
</div>
</div>
