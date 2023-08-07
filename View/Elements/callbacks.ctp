<?php

if (!isset($button)) {
	$button = __('Sūtīt');
}

?>
<!-- The Modal -->
<div id="callbackModal" class="modal">

	<!-- Modal content -->
	<div class="modal-content">
		<div class="modal-header">
			<span class="close-modal">&times;</span>
			<h2><?= __('Atzvanīt') ?></h2>
		</div>
		<div class="modal-body">
			<div id="callbacksUpdate"></div>

			<?= $this->Form->create('Callbacks', ['default' => false, 'class' => 'form', 'id' => 'callbacksForm']) ?>

			<?= $this->Form->hidden('request_hash', ['value' => md5(Utils::uuid4())]) ?>

			<?= $this->Form->input('name', [
				'placeholder' => __('Vārds'),
				'required' => true,
				'label' => false
			]) ?>

			<?= $this->Form->input('phone', [
				'placeholder' => __('Telefons'),
				'required' => true,
				'label' => false,
				'type' => 'text'
			]) ?>

			<?= $this->Form->input('question', [
				'placeholder' => __('Jautājums'),
				'required' => true,
				'label' => false,
				'type' => 'textarea'
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
				'id' => 'callback-get-news'
			]) ?>
			<div id="getNewsFields" style='display:none'>
				<?= $this->Form->input('company', [
					'placeholder' => __('Uzņēmums'),
					'label' => false,
				]) ?>

				<?= $this->Form->input('email', [
					'placeholder' => __('E-pasts'),
					'label' => false,
				]) ?>
			</div>

			<?php if (!empty($product_id)): ?>
				<?= $this->Form->hidden('product_id', [
					'value' => $product_id
				]) ?>
			<?php endif ?>
			<div class="submit-loader">
				<?= $this->Form->submit($button, ['class' => 'button button-send', 'id' => 'callbacksSubmit']) ?>
				<div class="loader" id="loading"></div>
			</div>

			<?= $this->Form->end() ?>


		</div>
	</div>

</div>

