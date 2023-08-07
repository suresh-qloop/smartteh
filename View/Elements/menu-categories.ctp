<?php

if (!$menu_categories) {
	return;
}

if (!isset($bc)) {
	$bc = [];
}

foreach ($menu_categories as $k => $v) {
	if (in_array($v['Category']['id'], $bc)) {
		array_unshift($menu_categories, $v);
		unset($menu_categories[$k + 1]);
		break;
	}
}

$category_view = (in_array($this->request->controller, ['categories', 'products']) && $this->request->action === 'view');

?>
<div class="container" id="categories">
	<section class="section">
		<?php if ($this->request->controller === 'start'): ?>
			<header class="section-header">
				<h2 class="section-heading">
					<?= __('Iekārtas') ?>
				</h2>
				<div class="section-description text-content">
					<?= isset($section_headings['categories']) ? nl2br($section_headings['categories']) : null ?>
				</div>
			</header>
		<?php endif ?>
		<div class="block-categories">
			<?php foreach ($menu_categories as $v): ?>
				<?php

				$p = ['class' => 'block-category', 'escape' => false];
				if ($category_view && in_array($v['Category']['id'], $bc)) {
					$p['class'] .= ' active';
				}

				if ($v['Category']['filename_menu']) {
					$p['style'] = 'background-image: url(/uploads/images/categories/menu/'.$v['Category']['filename_menu'].')';
				}

				$content = '<span class="block-category-title">'.$v['Category']['title_'.$lang].'</span>';

				echo $this->Html->link($content, ['controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$lang]], $p);

				?>
			<?php endforeach ?>
		</div>
</div>
