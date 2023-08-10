<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
	<meta charset="UTF-8" />
	<title><?= $title_for_layout ?> [admin]</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&amp;subset=latin,latin-ext,cyrillic" rel="stylesheet" type="text/css" />
	<?= $this->AssetCompress->css('admin-default') ?>
</head>
<body>
<header>
	<div class="r">
		<nav>
			<?= $this->Html->link(__d('admin', 'Frontend'), ['admin' => false, 'controller' => 'start', 'action' => 'index']) ?>
		</nav>

		<nav>
			<ul>
				<?php

				$languages = Configure::read('Languages.all');
				$hidden = ['ro'];

				if (count($languages) > 1) {
					foreach ($languages as $l => $title) {
						if (in_array($l, $hidden)) {
							continue;
						}

						$p = ['data-switch-lang' => $l];

						if ($l == $lang) {
							$p['class'] = 'active';
						}

						echo '<li>'.$this->Html->link($title, array_merge(['lang' => $l], $this->request->pass), $p).'</li>';
					}
				}

				?>
			</ul>
		</nav>

		<nav>
			<?= $this->Html->link(__d('admin', 'Log out').' <span class="fa fa-sign-out"></span>', ['admin' => false, 'controller' => 'admins', 'action' => 'logout'], ['escape' => false]) ?>
		</nav>
	</div>

	<h1>
			<span class="site-title">
				<?= __d('admin', 'Content Management System') ?>
			</span>
		<?= $this->Html->image('admin/loading.gif', ['alt' => __d('admin', 'loading...'), 'id' => 'ajax-loading']) ?>
	</h1>
</header>

<div class="container">
	<?= $this->element('admin/menu') ?>

	<div class="content">
		<?= $this->Flash->render() ?>
		<?= $this->fetch('content') ?>
	</div>
</div>

<script src="<?= Router::url('/tinymce/tinymce.min.js') ?>"></script>

<?= $this->AssetCompress->script('admin-default') ?>
<?= $this->fetch('script') ?>

</body>
</html>
