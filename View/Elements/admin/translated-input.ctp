<?php

/* @var string $model */

if (isset($this->request->data[$model]['translated'])) {
	$checked = $this->request->data[$model]['translated'];
} else {
	// We are in create mode.
	$checked = [$lang];
}

?>
<div class="input">
	<label>
		<?= __d('admin', 'Translated') ?>
	</label>
	<div class="checkboxes">
		<?php foreach (Configure::read('Languages.all') as $language => $label) : ?>
			<?= $this->Form->input('translated', [
				'checked' => in_array($language, $checked),
				'name' => 'data[' . $model . '][translated][]',
				'id' => 'translated-' . $language,
				'hiddenField' => false,
				'value' => $language,
				'type' => 'checkbox',
				'label' => $label,
			]) ?>
		<?php endforeach ?>
	</div>
</div>