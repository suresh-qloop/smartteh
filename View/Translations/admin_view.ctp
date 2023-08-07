<?php $this->set('title_for_layout', $page_title = __d('admin', 'Localization').' » '.$info['language']) ?>

<div class="tools">
	<?php if (count($list_domains) > 1): ?>
		<?= $this->Form->input('domain', [
			'options' => $list_domains,
			'type' => 'select',
			'label' => false,
			'name' => false,
			'id' => false
		]) ?>
	<?php endif ?>

	<?= $this->element('admin/tabs', ['data' => Translation::getAdminTabs()]) ?>
</div>

<h2><?= $page_title ?></h2>

<?php if (!empty($data)): ?>

	<?php if ($writable): ?>
		<?= $this->Form->create('Translation', ['url' => ['action' => 'update'], 'inputDefaults' => ['class' => 'txt']]) ?>
	<?php endif ?>

	<table class="list">
		<tr>
			<th style="width:50%"><?= __d('admin', 'Original') ?></th>
			<th style="width:50%"><?= __d('admin', 'Translation') ?></th>
		</tr>
		<?php foreach ($data as $k => $v): ?>
			<?php if ($v['msgstr'] != ''): ?>
				<tr>
					<td><label for="Translation<?= $k ?>Msgstr"><?= h($v['msgid']) ?></label></td>
					<td><?php

						if ($writable) {
							echo $this->Form->input('Translation.'.$k.'.msgstr', [
								'value' => $v['msgstr'],
								'label' => false,
								'div' => false
							]);

							echo $this->Form->hidden('Translation.'.$k.'.msgid', [
								'value' => $v['msgid']
							]);

						} else {
							echo $v['msgstr'];
						}

						?></td>
				</tr>
			<?php endif ?>
		<?php endforeach ?>
	</table>

	<?php if ($writable): ?>
		<?= $this->element('admin/button', [
			'label' => __d('admin', 'Save'),
			'div' => 'submit',
			'icon' => 'save'
		]) ?>

		<?= $this->Form->end() ?>
	<?php endif ?>

<?php else: ?>

	<br />
	<p><?= __d('admin', 'None of the texts are translated') ?></p>

<?php endif ?>
