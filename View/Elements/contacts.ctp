<?php

if (!isset($button)) {
	$button = __('Sūtīt vēstuli');
}

?>

<?= $this->Form->create('Contacts', ['url' => ['action' => 'index'], 'class' => 'form']) ?>

<?= $this->Form->hidden('request_hash', ['value' => md5(Utils::uuid4())]) ?>
<?= $this->Form->hidden('page_url', ['value' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"]) ?>

<?= $this->Form->input('name', [
	'placeholder' => __('Uzņēmums'),
	'required' => true,
	'label' => false,
	'id'=>'name',
]) ?>

<?= $this->Form->input('email', [
	'placeholder' => __('E-pasts'),
	'required' => true,
	'label' => false,
	'id'=>'email',
]) ?>

<?php if (!empty($show_phone)): ?>
	<?= $this->Form->input('phone', [
		'placeholder' => __('Telefons'),
		'required' => false,
		'label' => false,
		'id'=>'phone',
	]) ?>
<?php endif ?>

<?= $this->Form->input('text', [
	'placeholder' => __('Ziņa'),
	'required' => true,
	'label' => false,
	'id'=>'text',
]) ?>

<?= $this->Form->input('comment', [
	'placeholder' => __('Ziņa'),
	'class' => 'robots-are-cool',
	'type' => 'textarea',
	'required' => false,
	'label' => false,
	'div' => false,
	'id'=>'comment',
]) ?>

<?= $this->Form->input('get_news', [
	'type' => 'checkbox',
	'required' => false,
	'label' => __('Vēlos saņemt jaunumus'),
	'style' => 'margin:0 10px 0 5px',
	'id'=>'checkbox',
]) ?>

<?php if (!empty($product_id)): ?>
	<?= $this->Form->hidden('product_id', [
		'value' => $product_id,
		'id'=>'productid',
	]) ?>
<?php endif ?>

<?= $this->Form->submit($button, ['class' => 'button button-send']) ?>

<?= $this->Form->end() ?>
