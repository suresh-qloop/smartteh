<?php
if (!isset($active_id)) {
	$active_id = -1;
}

$menu_items = [];
foreach ($data as $k => $v) {
	if (in_array($v['Category']['id'], $bc)) {
		$menu_items = $v['children'];
		break;
	}
}
?>
<nav class="sidebar">
	<?php
	foreach ($menu_items as $v) {
		$class = 'sidebar-item';

		if (in_array($v['Category']['id'], $bc)) {
			$class .= ' active';
		}

		echo $this->Html->link($v['Category']['title_'.$lang], ['controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$lang]], ['class' => $class]);
	}
	?>
	<br /><br />
	<?php if (!empty($products)): ?>
		<h2>
			<?= __('Iekārtas') ?>
		</h2>
		<?php foreach ($products as $v): ?>
			<a href="<?= $this->Html->url(['controller' => 'products', 'action' => 'view', $v['Product']['strid_'.$lang], '?' => 'from=category']) ?>" class="product-item">
				<?php
				if ($v['Product']['filename']) {
					echo $this->Html->uploadedImage('products/large/'.$v['Product']['filename']);
				} else {
					echo $this->Html->image('product.png');
				}
				?>
				<span class="product-title"><?= $v['Product']['title_'.$lang] ?></span>
			</a>
		<?php endforeach ?>
	<?php endif ?>
</nav>
