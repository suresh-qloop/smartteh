<?php

/* @var array $menu_services */

if (!isset($bc)) {
	$bc = [];
}

$service_view = (in_array($this->request->controller, ['services']) && $this->request->action == 'view');

?>
<div class="container">
	<div class="block-categories">
		<?php foreach ($menu_services as $v): ?>
			<?php

			$p = ['class' => 'block-category', 'escape' => false];
			if ($service_view && in_array($v['Service']['id'], $bc)) {
				$p['class'] .= ' active';
			}

			if ($v['Service']['filename_menu']) {
				$p['style'] = 'background-image: url(/uploads/images/services/menu/'.$v['Service']['filename_menu'].')';
			}

			$content = '<span class="block-category-title">'.$v['Service']['title_'.$lang].'</span>';

			echo $this->Html->link($content, ['controller' => 'services', 'action' => 'view', $v['Service']['strid_'.$lang]], $p);

			?>
		<?php endforeach ?>
	</div>
</div>
