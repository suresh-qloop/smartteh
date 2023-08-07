<div class="quotes">
	<div class="quotes-inner">
		<?php foreach ($data as $k => $v): ?>
			<?= $this->element('quote', ['data' => $v, 'active' => ($k === 0)]) ?>
		<?php endforeach ?>
	</div>

	<?php if (count($data) > 1): ?>
		<button class="arrow arrow-right next-quote-button" id="next-quote-button">
			<?= __('Nākamā') ?>
		</button>
	<?php endif ?>
</div>
