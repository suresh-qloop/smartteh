<?php

/* @var array $breadcrumbs */

?>
<div class="color-faded flex">
	<?php foreach ($breadcrumbs as $breadcrumb): ?>
		/ <?= $this->Html->link($breadcrumb['title'], $breadcrumb['url'], ['class' => 'dont-track']) ?>
	<?php endforeach ?>
</div>
