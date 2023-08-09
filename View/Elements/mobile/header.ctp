<header class="page-header" id="header">
	<button type="button" class="menu-btn js-menu-btn" aria-label="menu button"></button>
	<?php

	$img = $this->Html->image('mobile/logo.png', ['alt' => 'logo', 'width' => 121, 'height' => 40]);
	echo $this->Html->link($img, ['controller' => 'start', 'action' => 'index'], ['class' => 'site-logo dont-track', 'escape' => false]);

	?>
</header>
