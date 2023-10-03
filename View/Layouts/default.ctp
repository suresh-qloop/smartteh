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

	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400|Roboto:300,300i,400&amp;subset=cyrillic,latin-ext" rel="stylesheet" />

	<link rel="icon" href="/favicon.gif?v=2" />
	<link rel="alternate" href="<?= Router::url($this->here, true) ?>" hreflang="<?= $lang ?>" />

	<?php if ($this->Html->isTestSite()): ?>
		<meta name="robots" content="noindex, follow" />
	<?php elseif (!empty($canonical)): ?>
		<link rel="canonical" href="<?= $this->Html->url($canonical, true) ?>" />
		<meta name="robots" content="noindex, follow" />
	<?php elseif (!empty($robots_noindex)): ?>
		<meta name="robots" content="noindex, follow" />
	<?php endif ?>

	<?php foreach ($urls ?? [] as $hreflang => $href): ?>
	<link rel="alternate" hreflang="<?= $hreflang ?>" href="<?= $href ?>" />
	<?php endforeach ?>

	<link rel="alternate" hreflang="x-default" href="<?= isset($urls) ? ($urls['en'] ?? current($urls)) : '' ?>" />

	<?= $this->element('social-meta-tags') ?>

	<?= $this->AssetCompress->css('default') ?>

	<?= $this->AssetCompress->css('print', ['media' => 'print']) ?>

	<?php if ($this->Session->check('Admin')): ?>
		<?= $this->AssetCompress->css('admin-frontend') ?>
	<?php endif ?>
	<?= $this->element('tag-manager') ?>
	<script src="https://platform-api.sharethis.com/js/sharethis.js#property=5f1579372a81520019e10427&product=inline-share-buttons" async="async"></script>
</head>
<body class="preload c-<?= $this->request->controller ?>" id="top">

<?= $this->element('admin/toolbar') ?>

<?php if ($this->request->controller !== 'start'): ?>
<div class="bodywrap">
	<?php endif ?>

	<?= $this->element('header') ?>

	<?= $this->Flash->render() ?>

	<?= $content_for_layout ?>

	<?= $this->element('floating-sidebar') ?>
	<?php if ($this->request->controller !== 'start'): ?>
	<div class="clear"></div>
	<div class="footer-push"></div>
</div>
<?php endif ?>

<?php /*echo $this->element('helpbox')*/ ?>

<?= $this->element('footer') ?>

<?php if ($this->request->controller === 'start'): ?>
	<?php /* unclosed div is opened in header */ ?>
	</div>
<?php endif ?>

<?= $this->AssetCompress->script('default') ?>

<?php if ($this->Session->check('Admin')): ?>
	<?= $this->AssetCompress->script('admin-frontend') ?>
<?php endif ?>

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
