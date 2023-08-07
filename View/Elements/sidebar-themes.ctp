<nav class="sidebar">
	<h2>
		<?= __('Tēmas') ?>
	</h2>

	<?php
	foreach ($data as $v) {
		$class = 'sidebar-item';
		if ($active && $v['Theme']['id'] == $active) {
			$class .= ' active';
		}
		echo $this->Html->link($v['Theme']['title_'.$lang], ['controller' => 'articles', 'action' => 'index', $v['Theme']['strid_'.$lang]], ['class' => $class]);
	}
	?>
</nav>
