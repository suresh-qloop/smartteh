<?php

$button = $button ?? __('Sūtīt vēstuli');

?>
<div id="contactsModal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close-modal">&times;</span>
			<h2><?= __('Kontakti') ?></h2>
		</div>
		<div class="modal-body">
			<div id="contactsUpdate"></div>
			<?= $this->Form->create('Contacts', ['url' => ['action' => 'index'], 'class' => 'form', 'id' => 'contactsForm']) ?>

			<?= $this->Form->hidden('request_hash', ['value' => md5(Utils::uuid4())]) ?>
			<?= $this->Form->hidden('page_url', ['value' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"]) ?>

			<?= $this->Form->input('name', [
				'placeholder' => __('Uzņēmums'),
				'required' => true,
				'label' => false
			]) ?>

			<?= $this->Form->input('email', [
				'placeholder' => __('E-pasts'),
				'required' => true,
				'label' => false
			]) ?>

			<?= $this->Form->input('phone', [
				'placeholder' => __('Telefons'),
				'required' => false,
				'label' => false
			]) ?>

			<?= $this->Form->input('text', [
				'placeholder' => __('Ziņa'),
				'required' => true,
				'label' => false
			]) ?>

			<?= $this->Form->input('comment', [
				'placeholder' => __('Ziņa'),
				'class' => 'robots-are-cool',
				'type' => 'textarea',
				'required' => false,
				'label' => false,
				'div' => false
			]) ?>

			<?= $this->Form->input('get_news', [
				'type' => 'checkbox',
				'required' => false,
				'label' => __('Vēlos saņemt jaunumus'),
				'style' => 'margin:0 10px 0 5px',
				'id' => 'contacts-get-news'
			]) ?>

			<?php if (!empty($product_id)): ?>
				<?= $this->Form->hidden('product_id', [
					'value' => $product_id
				]) ?>
			<?php endif ?>

			<div class="submit-loader">
				<?= $this->Form->submit($button, ['class' => 'button button-send', 'id' => 'contactsSubmit']) ?>
				<div class="loader" id="loadingCon"></div>
			</div>

			<?= $this->Form->end() ?>

		</div>
	</div>

</div>

