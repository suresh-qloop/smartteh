<?php $this->set('title_for_layout', $page_title = __('Kontakti')) ?>

<div class="container">
	<article class="article block content">
		<header class="article-header">
			<h1><?= $page_title ?></h1>
		</header>

		<?php if (!empty($done)): ?>
			<p>
				<?= __('Paldies! Jūsu ziņa ir nosūtīta.') ?>
				<br /><br />
				<?= $this->Html->link(__('Atpakaļ uz sākumu'), ['controller' => 'start', 'action' => 'index'], ['class' => 'dont-track']) ?>
			</p>
		<?php else: ?>
			<?= $this->element('contacts') ?>
		<?php endif ?>
	</article>
</div>
