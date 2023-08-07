<?php $this->set('title_for_layout', $page_title = $data['Service']['title_'.$lang]) ?>

<?= $this->element('admin/tools') ?>

<div class="container">
	<div class="article-container">
		<article class="article">

			<div class="d-flex align-v mb-md hide-mobile">
				<?= $this->element('breadcrumbs', ['breadcrumbs' => $breadcrumbs]) ?>
			</div>

			<h1>
				<?= $page_title ?>
			</h1>

			<div class="article-body">
				<?= $data['Service']['description_'.$lang] ?>
			</div>
			<br /><br />

			<div class="no-print">
				<h2>
					<?= __('Jautājumi?') ?>
				</h2>
				<?= $this->element('contacts', ['service_id' => $data['Service']['id'], 'show_phone' => true]) ?>
			</div>

		</article>
	</div>

</div>
