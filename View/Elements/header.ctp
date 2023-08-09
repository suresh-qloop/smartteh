<header class="site-header" id="site-header">

	<div class="container">

		<div class="site-header-tools">
			<div class="social-icons header">
				<a class="dont-track" target="_blank" href="https://www.linkedin.com/company/smartteh/" aria-label="Linkedin url">
					<i class="fa fa-linkedin" aria-hidden="true"></i>
				</a>
				<a class="dont-track" target="_blank" href="https://www.facebook.com/www.smartteh.eu/?eid=ARAMOOI_pygFWX_5bKGEv96XQvTGlcxr66J5JEVPhM_iCNjPw6h3HnPnqxkCvQUv5OO_KRJ03sNx9uJd" aria-label="Facebook url">
					<i class="fa fa-facebook-f" aria-hidden="true"></i>
				</a>
				<a class="dont-track" target="_blank" href="https://www.instagram.com/smartteh.eu/" aria-label="Instagaram url">
					<i class="fa fa-instagram" aria-hidden="true"></i>
				</a>
				<a class="dont-track" target="_blank" href="https://www.youtube.com/channel/UC_JssqWfmT3jWyPHjiPuUAw" aria-label="Youtube url">
					<i class="fa fa-youtube" aria-hidden="true"></i>
				</a>
			</div>

			<?= $this->element('languages') ?>
		</div>
	</div>

</header>

<?php if ($this->request->controller === 'start'): ?>

<?= $this->element('bg-top') ?>

<div class="page-intro-heading big-page-intro-heading">
	<div class="container">
		<?= $this->element('mainmenu') ?>
	</div>
	<div>
		<div class="video-overlay"></div>
		<?php
		echo $this->Html->media('smartteh.mp4', ['tag' => 'video', 'class' => 'slide-video', 'autoplay', 'muted', 'loop']);
		?>
	</div>

	<?= $this->element('slides') ?>
</div>

<div class="fake-body-bg">
	<?= $this->element('menu-categories') ?>
	<?php /* don't close this div here */ ?>

	<?php else: ?>

		<?php

		if (!empty($page_header_image)) {
			$style = 'style="background-image:url('.$page_header_image.')"';
		} else {
			$style = '';
		}

		?>
		<div class="page-intro-heading" <?= $style ?>>
			<div class="container">
				<?= $this->element('mainmenu') ?>
			</div>

			<?php

			$menu = null;

			switch ($this->request->controller) {
				case 'categories':
				case 'services':
				case 'industries':
					$menu = $this->request->controller;
					break;

				case 'products':
					$menu = $from === 'industry' ? 'industries' : 'categories';
			}

			if ($menu) {
				echo $this->element('menu-'.$menu);
			}

			?>
		</div>

	<?php endif ?>
