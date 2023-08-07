<div class="sidenav">
	<?php if (isset($data['Product'])): ?>
		<div class="hover-menu">
			<p title="<?= __('Dalīties') ?>"><i class="fa fa-share-alt" aria-hidden="true"></i></p>
			<div class="share-items">
				<?= $this->Form->create('Product', ['url' => ['action' => 'share_via_email'], 'class' => 'item product-send-form']) ?>
				<?= $this->Form->email('share_email', ['class' => 'product-send-input', 'placeholder' => __('Nosūti draugam...')]) ?>
				<button type="submit" class="product-send-button">
					<i class="fa fa-paper-plane"></i>
				</button>
				<?= $this->Form->hidden('id', ['value' => $data['Product']['id']]) ?>
				<?= $this->Form->end() ?>

				<!-- ShareThis BEGIN -->
				<!--                <div class="sharethis-inline-share-buttons"></div>-->
				<!-- ShareThis END -->
			</div>

		</div>
	<?php endif ?>

	<!--    <a href="#about" data-network="facebook"><i class="fa fa-share-alt" aria-hidden="true"></i></a>-->
	<?php if (isset($data['Product'])): ?>
		<?= $this->Html->link('<i class="fa fa-file-pdf-o hover-download" aria-hidden="true"></i>',
			['action' => 'pdf', $data['Product']['strid_'.$lang]],
			['title' => __('Lejupielādēt PDF'), 'escape' => false]) ?>
	<?php endif ?>
	<button id="contactForm" title="<?= __('Kontakti') ?>"><i class="fa fa-envelope" aria-hidden="true"></i></button>

	<button id="callbackForm" title="<?= __('Atzvanīt') ?>"><i class="fa fa-phone" aria-hidden="true"></i></button>
</div>
