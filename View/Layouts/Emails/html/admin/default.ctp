<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="<?= $lang ?>">
<head>
	<title><?= isset($title_for_layout) ? $title_for_layout : '' ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<div class="block header">
	<a href="<?= Router::url('/', true) ?>" target="_blank">
		<img src="<?= Router::url('/img/logo_white.png', true) ?>" />
	</a>
</div>

<div class="block content">
	<?php

	$text = $this->fetch('content');

	if (!$text && isset($content_for_layout)) {
		$text = $content_for_layout;
	}

	echo $text;

	?>
</div>

<div class="block footer">
	<p>
		&copy; <?= date('Y') ?>
	</p>
</div>

</body>
</html>
