<?php $this->set('title_for_layout', $page_title = 'Page not found') ?>

<h1><?= $page_title ?></h1>

<p>
	It’s looking like you may have taken a wrong turn.
	Don’t worry, it happens to the best of us.
</p>

<nav>
	Here’s a little map that might help you get back on track:
	<?= $this->Html->link('Home', '/') ?>
</nav>

<?php if (Configure::read('debug') > 0): ?>
	<?= $this->element('exception_stack_trace') ?>
<?php endif ?>
