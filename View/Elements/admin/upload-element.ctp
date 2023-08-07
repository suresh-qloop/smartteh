<?php

/*
params:
	model - required
	field - required
	label - required
	preview_dir - optional
	required - optional
	info - optional
*/

$container_class = 'input upload-element media';
$id = md5($model.'_'.$field);
$input_name = $field.'_file';
$preview_class = 'preview img';
$filepath = false;
$image = false;

if (!isset($required)) {
	$required = false;
}

if ($required) {
	$container_class .= ' required';
}

if (!empty($this->request->data[$model][$field])) {
	$filename = $this->request->data[$model][$field];

	if (!empty($preview_dir)) {
		$filepath = $preview_dir.$filename;
	}

	$container_class .= ' has-file';

	$extension = Utils::getExtension($filename);

	if (in_array($extension, ['flv', 'avi', 'mp4', 'mpg', 'mpeg', 'mkv'])) {
		$preview_class .= ' video';
	} else {
		if (in_array($extension, ['mp3', 'wav', 'flac'])) {
			$preview_class .= ' audio';
		} else {
			if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
				$preview_class .= ' image';

				if ($filepath) {
					$image = true;
				}
			} else {
				$preview_class .= ' generic';
			}
		}
	}
}

?>
<div class="<?= $container_class ?>">
	<label for="<?= $id ?>"><?= $label ?></label>
	<?php if (!empty($info)): ?>
		<span class="info"><?= $info ?></span>
	<?php endif ?>
	<div class="<?= $preview_class ?>">
		<?php if (!empty($image)): ?>
			<?= $this->Html->image($filepath) ?>
		<?php endif ?>
	</div>
	<div class="bd">
		<?= $this->Form->input($input_name, [
			'required' => $required,
			'label' => false,
			'type' => 'file',
			'div' => false,
			'id' => $id
		]) ?>

		<div class="action-btns">
			<label for="<?= $id ?>" class="action-btn"><?= __d('admin', 'Change') ?></label>
			<button type="button" class="action-btn delete" data-upload-element-delete="<?= $id ?>"><?= __d('admin', 'Delete') ?></button>
		</div>

		<div class="filename js-filename">
			<?php if (!empty($filepath)): ?>
				<?= $this->Html->link(basename($filepath), '/img/'.$filepath) ?>
			<?php endif ?>
		</div>
	</div>

	<?= $this->Form->hidden('delete_'.$field, ['id' => 'upload-element-delete-'.$id]) ?>
	<?= $this->Form->hidden($field) ?>
</div>
