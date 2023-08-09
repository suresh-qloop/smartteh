<?php

/* @var array $menu_categories */
/* @var array $menu_industries */
/* @var array $menu_article */
/* @var array $menu_services */
/* @var array $menu_blocks */

$category_view = ($this->request->controller === 'categories' && $this->request->action === 'view');
$industry_view = ($this->request->controller === 'industries');
$service_view = ($this->request->controller === 'services');
$active_articles = $this->request->controller === 'articles';

$category_strid = $menu_categories[0]['Category']['strid_'.$lang];
$industry_strid = $menu_industries[0]['Industry']['strid_'.$lang];
if ($menu_article) {
	$article_strid = $menu_article[0]['Article']['strid_'.$lang];
}
$service_strid = null;

if ($menu_services) {
	$service_strid = $menu_services[0]['Service']['strid_'.$lang];
}

?>
<div class="mainmenu" id="mainmenu">

	<button type="button" class="menu-btn js-menu-btn" aria-label="menu button"></button>

	<?= $this->element('languages') ?>

	<ul class="nav">

		<li>

			<?= $this->Html->link(__('Iekārtas'), ['controller' => 'categories', 'action' => 'view', $category_strid, '#' => 'categories'], [
				'data-submenu' => '#submenu-categories',
				'class' => 'dont-track'.($category_view ? 'active' : '')
			]) ?>

			<ul class="nav-2" id="submenu-categories">
				<?php foreach ($menu_categories as $v): ?>
					<li>
						<?php

						$p = [];
						$p['class'] = 'dont-track';
						if ($category_view && isset($bc[0]) && $bc[0] == $v['Category']['id']) {
							$p['class'] .= 'active';
						}

						if ($v['children']) {
							$p['data-submenu'] = '#submenu-categories-'.$v['Category']['id'];
						}

						echo $this->Html->link($v['Category']['title_'.$lang], ['controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$lang]], $p);

						?>

						<?php if ($v['children']): ?>
							<ul class="nav-3" id="submenu-categories-<?= $v['Category']['id'] ?>">
								<?php foreach ($v['children'] as $v2): ?>
									<li>
										<?php

										$p = [];
										$p['class'] = 'dont-track';
										if ($category_view && isset($bc[1]) && $bc[1] == $v2['Category']['id']) {
											$p['class'] .= 'active';
										}

										echo $this->Html->link($v2['Category']['title_'.$lang], ['controller' => 'categories', 'action' => 'view', $v2['Category']['strid_'.$lang]], $p);

										?>
									</li>
								<?php endforeach ?>
							</ul>
						<?php endif ?>
					</li>
				<?php endforeach ?>
			</ul>
		</li>

		<?php if ($menu_services): ?>
			<li>
				<?= $this->Html->link(__('Pakalpojumi'), ['controller' => 'services', 'action' => 'view', $service_strid, '#' => 'services'], [
					'data-submenu' => '#submenu-services',
					'class' => 'dont-track'.($service_view ? 'active' : '')
				]) ?>

				<ul class="nav-2" id="submenu-services">
					<?php foreach ($menu_services as $v): ?>
						<li>
							<?php

							$p = [];
							$p['class'] = 'dont-track';
							if ($service_view && isset($bc[0]) && $bc[0] == $v['Service']['id']) {
								$p['class'] .= 'active';
							}

							echo $this->Html->link($v['Service']['title_'.$lang], ['controller' => 'services', 'action' => 'view', $v['Service']['strid_'.$lang]], $p);

							?>
						</li>
					<?php endforeach ?>
				</ul>
			</li>
		<?php endif ?>

		<li>
			<?= $this->Html->link(__('Industrijas'), ['controller' => 'industries', 'action' => 'view', $industry_strid], [
				'data-submenu' => '#submenu-industries',
				'class' => 'dont-track'.($industry_view ? 'active' : '')
			]) ?>

			<ul class="nav-2" id="submenu-industries">
				<?php foreach ($menu_industries as $v): ?>
					<li>
						<?php

						$p = [];
						$p['class'] = 'dont-track';
						if ($industry_view && isset($bc[0]) && $bc[0] == $v['Industry']['id']) {
							$p['class'] .= 'active';
						}

						echo $this->Html->link($v['Industry']['title_'.$lang], ['controller' => 'industries', 'action' => 'view', $v['Industry']['strid_'.$lang]], $p)

						?>

					</li>
				<?php endforeach ?>
			</ul>
		</li>

		<?php if ($menu_blocks['portfolio']): ?>
			<li><?= $this->Html->link(__('Portfolio'), ['controller' => 'portfolio', 'action' => 'index'], ['class' => 'dont-track']) ?></li>
		<?php endif ?>
		<?php if ($menu_article): ?>
			<li><?= $this->Html->link(__('Blogs'), ['controller' => 'articles', 'action' => 'index'], ['class' => 'dont-track']) ?></li>
		<?php endif ?>

		<li><?= $this->Html->link(__('Partneri'), ['controller' => 'start', 'action' => 'index', '#' => 'partners'], ['class' => 'dont-track']) ?></li>

		<li><?= $this->Html->link(__('Par mums'), ['controller' => 'start', 'action' => 'index', '#' => 'about-us'], ['class' => 'dont-track']) ?></li>

		<li><?= $this->Html->link(__('Kontakti'), ['controller' => 'start', 'action' => 'index', '#' => 'contacts'], ['class' => 'dont-track']) ?></li>

	</ul>
</div>
