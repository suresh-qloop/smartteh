<?php

$class = 'helpbox';

if (isset($_COOKIE['helpbox'])) {
	switch ($_COOKIE['helpbox']) {
		case 'minimized':
			$class .= ' minimized';
			break;

		case 'maximized':
			$class .= ' maximized';
			break;

		case 'closed':
			return;
			break;
	}
}

?>
<div class="<?= $class ?>" id="helpbox">
	<div class="titlebar media" id="helpbox-titlebar">
		<div class="img r">
			<button class="btn btn-minimize" id="helpbox-minimize" title="<?= __('Samazināt') ?>">_</button>
			<button class="btn btn-maximize" id="helpbox-maximize" title="<?= __('Palielināt') ?>">+</button>
			<button class="btn btn-close" id="helpbox-close" title="<?= __('Aizvērt') ?>">×</button>
		</div>

		<div class="bd">
			<?= __('Kā mēs varam Jums palīdzēt?') ?>
		</div>
	</div>

	<div class="inner" id="helpbox-body">
		<?= $this->element('contacts', ['title' => false, 'button' => __('Uzdot jautājumu')]) ?>
	</div>
</div>
