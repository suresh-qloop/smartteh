<?php $this->set('title_for_layout', $page_title = __d('admin', 'Administrators').' » '.__d('admin', 'edit')) ?>

<?php if (!$data['Admin']['root']): ?>
	<div class="tools">
		<a href="<?= $this->Html->url(['action' => 'delete', $id]) ?>" class="btn btn-compact btn-danger btn-w-icon confirm">
			<span class="fa fa-trash"></span>
			<?= __d('admin', 'Delete') ?>
		</a>
	</div>
<?php endif ?>

<h2><?= $page_title ?></h2>

<?= $this->Form->create('Admin', ['url' => ['action' => 'update']]) ?>

<?= $this->Form->input('name', [
	'label' => __d('admin', 'Name'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('username', [
	'between' => '<span class="info">'.__d('admin', 'Username can contain only letters and digits').'</span>',
	'label' => __d('admin', 'Username'),
	'div' => 'input text required',
	'required' => true
]) ?>

<?= $this->Form->input('email', [
	'label' => __d('admin', 'E-mail')
]) ?>

<?= $this->Form->input('change_password', [
	'label' => __d('admin', 'Change password'),
	'data-toggle-block' => 'admin-password',
	'type' => 'checkbox'
]) ?>

<div class="disabled hidden" data-block="admin-password" data-block-values="1">
	<?= $this->Form->input('password1', [
		'label' => __d('admin', 'Password (1x)'),
		'div' => 'input password required',
		'autocomplete' => 'off',
		'type' => 'password',
		'disabled' => true,
		'required' => true
	]) ?>

	<?= $this->Form->input('password2', [
		'label' => __d('admin', 'Password (2x)'),
		'div' => 'input password required',
		'autocomplete' => 'off',
		'type' => 'password',
		'disabled' => true,
		'required' => true
	]) ?>
</div>

<?= $this->Form->input('id') ?>

<?= $this->element('admin/button', [
	'label' => __d('admin', 'Save'),
	'div' => 'submit',
	'icon' => 'save'
]) ?>

<?= $this->Form->end() ?>
