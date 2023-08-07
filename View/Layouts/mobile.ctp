<?php

$title_prefix = !empty($is_frontpage) ? 'SmartTEH | ' : '';
$title_suffix = !empty($is_frontpage) ? '' : ' | SmartTEH';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<?php if (!empty($meta['Metatag']['title'])): ?>
		<title><?= $title_prefix.$meta['Metatag']['title'].$title_suffix ?></title>
	<?php else: ?>
		<title><?= $title_prefix.$title_for_layout.$title_suffix ?></title>
	<?php endif ?>

	<meta name="google-site-verification" content="44axL_N_hbyUB8bpyFfRLNKZkWXDoI3WLE469o_Hpes" />

	<?php if (!empty($meta['Metatag']['description'])): ?>
		<meta name="description" content="<?= $meta['Metatag']['description'] ?>" />
	<?php endif ?>

	<?php if (!empty($meta['Metatag']['keywords'])): ?>
		<meta name="keywords" content="<?= $meta['Metatag']['keywords'] ?>" />
	<?php endif ?>

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400|Roboto:300,300i,400&amp;subset=cyrillic,latin-ext" rel="stylesheet" />

	<link rel="icon" href="/favicon.gif?v=2" />

	<?= $this->AssetCompress->css('mobile') ?>
	<?= $this->element('social-meta-tags') ?>

	<?= $this->element('tag-manager') ?>
</head>
<body class="preload c-<?= $this->request->controller ?>">

<?= $this->element('mobile/header') ?>
<?= $this->Flash->render() ?>

<?= $this->element('mobile/mainmenu', ['data' => $menu_categories]) ?>

<?= $content_for_layout ?>
<?= $this->element('mobile/floating-sidebar') ?>

<?= $this->element('mobile/footer') ?>

<?= $this->AssetCompress->script('mobile') ?>

<?= $this->fetch('script') ?>

<?php if (!Configure::read('debug')): ?>
	<?= $this->element('tracking-scripts') ?>
<?php endif ?>
<?= $this->element('callbacks', ['product_id' => ($data['Product']['id'] ?? null)]) ?>
<?= $this->element('contactsForm', ['product_id' => ($data['Product']['id'] ?? null)]) ?>
<script>
	$("a:not(.dont-track)").click(function () {
		if (!$(this).parents('.paginator').length && (location.hostname === this.hostname || !this.hostname.length)) {
			let img = $(this).find('img');
			$.ajax({
				url: "/<?=$lang?>/tracking/saveclick",
				data: {
					'url': this.href,
					'url_path': this.href.replace(window.location.origin, ""),
					'place': $(location).attr("href"),
					'img': (img.length > 0 ? img.attr('src') : ''),
					'img_alt': (img.length > 0 ? img.attr('alt') : '')
				},
				type: 'POST',
			});
		}
	});
</script>
</body>
</html>
