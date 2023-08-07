<?php if (isset($success)): ?>
	<div class="msg success-msg">
		<h4> <?= __('Ziņa nosūtīta!') ?> </h4>
	</div>
	<script>
		const $form = document.getElementById('contactsForm');
		document.getElementById('ContactsRequestHash').value = '<?= $hash ?>';
		$form.reset();
		document.getElementById('contacts-get-news').checked = false;
		$('.success-msg').delay(5000).fadeOut();
	</script>
<?php elseif (isset($error)): ?>
	<div class="msg error-msg">
		<?php foreach ($error as $item): ?>
			<p> <?= $item[0] ?> </p>
		<?php endforeach ?>
	</div>
<?php endif ?>
