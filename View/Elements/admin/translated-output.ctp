<?php

/* @var array $values */

?>
<div class="d-flex">
	<?php foreach (Configure::read('Languages.all') as $language => $label): ?>
		<span class="mh-xxs <?= in_array($language, $values) ? 'text-strong' : 'disabled' ?>">
			<?= $label ?>
		</span>
	<?php endforeach ?>
</div>
