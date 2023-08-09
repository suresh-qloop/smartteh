<?php if ($this->request->controller === 'start'): ?>
	<div class="go-up-block">
		<a href="#top" class="arrow arrow-up go-up-link dont-track">
			<?= __('Uz augšu') ?>
		</a>
	</div>
<?php endif ?>

<footer class="site-footer">
	<div class="container">
		<div class="flex email">
			<?= $this->Html->preprocessText($settings['contacts-email']) ?>
		</div>
		<div class="flex social-icons">
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
		<div>
			© <?= date('Y') ?> SIA SMARTTEH
		</div>
	</div>
</footer>
