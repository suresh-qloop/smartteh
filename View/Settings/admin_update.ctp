<?php $this->set('title_for_layout', $page_title = __d('admin', 'Settings').' » '.__d('admin', 'edit')) ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Setting', ['url' => ['action' => 'update'], 'type' => 'file']) ?>

<?= $this->Form->input('title', [
	'label' => __d('admin', 'Title'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?php

switch ($this->data['Setting']['type']) {
	case 'boolean':
		echo $this->Form->input('value', [
			'options' => ['0' => __d('admin', 'No'), '1' => __d('admin', 'Yes')],
			'label' => __d('admin', 'Value'),
			'type' => 'select',
			'class' => 'num'
		]);
		break;

	case 'varchar':
		echo $this->Form->input('value', [
			'label' => __d('admin', 'Value'),
			'type' => 'text'
		]);
		break;

	case 'int':
		echo $this->Form->input('value', [
			'label' => __d('admin', 'Value'),
			'type' => 'number',
			'class' => 'num'
		]);
		break;

	case 'percents':
		echo $this->Form->input('value', [
			'label' => __d('admin', 'Value'),
			'type' => 'number',
			'class' => 'num',
			'after' => ' %',
			'max' => 100,
			'min' => 0
		]);
		break;

	case 'select':
		echo $this->Form->input('value', [
			'options' => (array)json_decode($this->data['Setting']['data']),
			'label' => __d('admin', 'Value'),
			'type' => 'select'
		]);

		echo $this->Form->input('data', [
			'label' => __d('admin', 'List values (JSON format)'),
		]);

		break;

	case 'file':
		echo $this->element('admin/upload-element', [
			'label' => __d('admin', 'File'),
			'preview_dir' => '../uploads/settings/',
			'field' => 'value',
			'model' => 'Setting'
		]);
		break;

	default:
		echo $this->Form->input('value', [
			'label' => __d('admin', 'Value')
		]);
}

?>

<?= $this->Form->hidden('type') ?>
<?= $this->Form->hidden('id') ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
