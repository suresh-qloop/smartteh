<?php

/* @var array $menu_industries */

if (!isset($bc)) {
	$bc = [];
}

$industry_view = (in_array($this->request->controller, ['industries', 'products']) && $this->request->action == 'view');

?>
<div class="container">
	<div class="block-categories">
		<?php foreach ($menu_industries as $v): ?>
			<?php

			$p = ['class' => 'block-category', 'escape' => false];
			if ($industry_view && in_array($v['Industry']['id'], $bc)) {
				$p['class'] .= ' active';
			}

			if ($v['Industry']['filename_menu']) {
				$p['style'] = 'background-image: url(/uploads/images/industries/menu/'.$v['Industry']['filename_menu'].')';
			}

			$content = '<span class="block-category-title">'.$v['Industry']['title_'.$lang].'</span>';

			echo $this->Html->link($content, ['controller' => 'industries', 'action' => 'view', $v['Industry']['strid_'.$lang]], $p);

			?>
		<?php endforeach ?>
	</div>
</div>
