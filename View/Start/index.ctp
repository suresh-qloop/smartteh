<?php $this->set('title_for_layout', $page_title = 'SmartTEH') ?>

<?php if ($services): ?>
	<?= $this->element('services', ['data' => $services]) ?>
<?php endif ?>

<?php if ($industries): ?>
	<?= $this->element('industries', ['data' => $industries]) ?>
<?php endif ?>

<?php if ($portfolio): ?>
	<?= $this->element('portfolio', ['data' => $portfolio]) ?>
<?php endif ?>

<?php if ($articles): ?>
	<?= $this->element('articles', ['data' => $articles]) ?>
<?php endif ?>

<?php if ($partners): ?>
	<?= $this->element('partners', ['data' => $partners]) ?>
<?php endif ?>

<div class="container" id="about-us">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Par mums') ?>
			</h2>
			<div class="section-description text-content">
				<?= nl2br($section_headings['about-us']) ?>
			</div>
		</header>
		<div class="section-content text-content">
			<div class="cols" style="background-image:url(/uploads/settings/<?= $settings['about-us-bg-image'] ?>)">
				<div class="col about-us-block article">
					<?= $this->Html->preprocessText($subsections['about']) ?>
				</div>
				<div class="col">
					<?= $this->element('quotes', ['data' => $quotes]) ?>
				</div>
			</div>
		</div>
	</section>
</div>
<?php if ($certificates): ?>
	<?= $this->element('certificates', ['data' => $certificates]) ?>
<?php endif ?>
<div class="container" id="contacts">
	<section class="section">
		<header class="section-header">
			<h2 class="section-heading">
				<?= __('Kontakti') ?>
			</h2>
			<div class="section-description text-content">
				<?= nl2br($section_headings['contacts']) ?>
			</div>
		</header>
		<div class="section-content text-content">
			<div class="cols">
				<div class="col employees-block">
					<?= $this->Html->preprocessText($subsections['contacts']) ?>
				</div>
				<div class="col contacts-block">
					<h3><?= __('Sazinies ar mums') ?></h3>

					<?= $this->element('contacts', ['show_phone' => true]) ?>

				</div>
			</div>
		</div>
	</section>
</div>
