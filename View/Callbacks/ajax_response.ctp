<?php if (isset($success)): ?>
	<div class="msg success-msg">
		<h4> <?= __('Ziņa nosūtīta!') ?> </h4>
	</div>
	<script>
		let form = document.getElementById('callbacksForm');
		document.getElementById('CallbacksRequestHash').value = '<?= $hash ?>';
		form.reset();
		document.getElementById('callback-get-news').checked = false;
		document.getElementById('getNewsFields').style.display = "none";
		document.getElementById('CallbacksCompany').required = false;
		document.getElementById('CallbacksEmail').required = false;
		$(".success-msg").delay(5000).fadeOut();
	</script>
<?php elseif (isset($error)): ?>
	<div class="msg error-msg">
		<?php foreach ($error as $item): ?>
			<p> <?= $item[0] ?> </p>
		<?php endforeach; ?>
	</div>

<?php endif ?>
