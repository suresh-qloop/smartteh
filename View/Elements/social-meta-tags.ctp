<?php if (!empty($meta['Metatag']['title'])): ?>
	<meta property='og:title' content='<?= $meta['Metatag']['title'] ?>' />
<?php else: ?>
	<meta property='og:title' content='<?= $title_for_layout ?>' />
<?php endif ?>

<?php if (!empty($meta['Metatag']['filename'])): ?>
	<meta property='og:image' content='<?= Router::url('/', true) ?>uploads/images/metatags/<?= $meta['Metatag']['filename'] ?>' />
<?php elseif (!empty($default_metatag_img)): ?>
	<meta property='og:image' content='<?= Router::url('/', true) ?>uploads/settings/<?= $default_metatag_img ?>' />
<?php endif ?>

<?php if (!empty($meta['Metatag']['description'])): ?>
	<meta property='og:description' content='<?= $meta['Metatag']['description'] ?>' />
<?php endif ?>

<meta property='og:url' content='<?= Router::url(null, true) ?>' />