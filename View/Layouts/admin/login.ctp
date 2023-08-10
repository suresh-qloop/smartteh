<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
	<meta charset="UTF-8" />
	<title><?= $title_for_layout ?> [admin]</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&amp;subset=latin,latin-ext,cyrillic" rel="stylesheet" type="text/css" />
	<?= $this->AssetCompress->css('admin-login') ?>
</head>
<body class="c-login">

<div class="login-container">
	<header>
		<h1>
				<span class="site-title">
					<?= __d('admin', 'Content Management System') ?>
				</span>
		</h1>
	</header>

	<div class="login-content">
		<?= $this->Flash->render() ?>
		<?= $this->fetch('content') ?>
	</div>
</div>

<?= $this->fetch('script') ?>

</body>
</html>
