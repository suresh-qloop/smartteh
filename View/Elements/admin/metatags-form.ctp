<?= $this->Form->create('Metatag', ['url' => ['action' => 'update_external'], 'type' => 'file']) ?>

<?= $this->Form->input('title', [
	'label' => __d('admin', 'Title')
]) ?>

<?= $this->Form->input('description', [
	'label' => __d('admin', 'Description')
]) ?>

<?= $this->Form->input('keywords', [
	'label' => __d('admin', 'Keywords')
]) ?>

<?= $this->element('admin/upload-element', [
	'label' => __d('admin', 'Image').' ('.__d('admin', 'Recomended size - ').Metatag::$IMAGE_SIZE['filename']['w'].'x'.Metatag::$IMAGE_SIZE['filename']['h'].')',
	'info' => __d('admin', 'Supported formats: PNG, JPG'),
	'preview_dir' => '../uploads/images/metatags/',
	'field' => 'filename',
	'model' => 'Metatag'
]) ?>

<?= $this->Form->hidden('controller', ['value' => $controller]) ?>
<?= $this->Form->hidden('action', ['value' => $action]) ?>
<?= $this->Form->hidden('pid', ['value' => $pid]) ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
