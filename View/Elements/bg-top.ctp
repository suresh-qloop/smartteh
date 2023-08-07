<?php

if (empty($slides)) {
	return;
}

?>
<div class="bg-top-container">
	<?php foreach ($slides as $k => $v): ?>
		<?php

		$class = 'bg-top-item';

		if ($k === 0) {
			$class .= ' active';
		}

		echo '<div class="'.$class.'" id="bg-top-'.($k + 1).'" style="background-image: url(/uploads/images/slides/bg/'.$v['Slide']['bg_filename'].')"></div>';

		?>
	<?php endforeach ?>
</div>
