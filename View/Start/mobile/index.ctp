<?php $this->set('title_for_layout', $page_title = 'SmartTEH') ?>

<div id="categories">
	<h2 class="mb-0"><?= __('Iekārtas') ?></h2>

	<?= $this->element('mobile/categories', ['data' => $menu_categories]) ?>
</div>

<?php if ($menu_services): ?>
	<div id="services">
		<h2 class="mb-0"><?= __('Pakalpojumi') ?></h2>

		<?= $this->element('mobile/services', ['data' => $menu_services]) ?>
	</div>
<?php endif ?>

<div id="industries">
	<h2 class="mb-0"><?= __('Industrijas') ?></h2>

	<?= $this->element('mobile/industries', ['data' => $industries]) ?>
</div>

<?php if ($portfolio): ?>
	<div id="portfolio">
		<h2 class="mb-0"><?= __('Portfolio') ?></h2>

		<?= $this->element('mobile/portfolio', ['data' => $portfolio]) ?>
	</div>
<?php endif ?>
<?php if ($articles): ?>
	<div id="blog">
		<h2 class="mb-0"><?= __('Articles') ?></h2>

		<?= $this->element('mobile/articles', ['data' => $articles]) ?>
	</div>
<?php endif ?>
<?php if ($partners): ?>
	<div id="partners">
		<h2 class="c"><?= __('Partneri') ?></h2>
		<?= $this->element('mobile/partners', ['data' => $partners]) ?>
	</div>
<?php endif ?>

<div id="about-us">
	<h2><?= __('Par mums') ?></h2>
	<div class="article-body">
		<?= substr($this->Html->preprocessText($subsections['about']), 0, 790) ?> ...
		<?= substr($this->Html->preprocessText($subsections['about']), strpos($subsections['about'], '<p><a class="button') - 1) ?>
	</div>
</div>
<?php if ($certificates): ?>
	<div id="partners">
		<h2 class="c"><?= __('Sertifikāti') ?></h2>
		<?= $this->element('mobile/certificates', ['data' => $certificates]) ?>
	</div>
<?php endif ?>
<div id="contacts">
	<h2><?= __('Jautājumi?') ?></h2>
	<?= $this->element('contacts', ['show_phone' => true]) ?>

</div>

<div>
	<h2><?= __('Kontakti') ?></h2>
	<div class="article-body">
		<?= $this->Html->preprocessText($subsections['contacts']) ?>
	</div>
</div>
