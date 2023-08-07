<?php $this->set('title_for_layout', $page_title = __d('admin', 'Settings')) ?>

<div class="tools">
	<?= $this->Html->link('<span class="fa fa-refresh"></span> '.__d('admin', 'Clear cache'), ['action' => 'clear_cache'], ['class' => 'btn btn-w-icon btn-compact', 'escape' => false]) ?>
</div>

<h2><?= $page_title ?></h2>

<?= $this->Paginator->options(['url' => ['?' => '']]) ?>
<table class="list js-gallery">
	<tr>
		<th><?= __d('admin', 'Title') ?></th>
		<th><?= __d('admin', 'Value') ?></th>
		<th class="nb"><?= __d('admin', 'Action') ?></th>
	</tr>
	<?php foreach ($data as $v): ?>
		<tr>
			<td><?= $v['Setting']['title'] ?></td>
			<td><?php

				switch ($v['Setting']['type']) {
					case 'boolean':
						echo (bool)$v['Setting']['value'] ? __d('admin', 'Yes') : __d('admin', 'No');
						break;

					case 'file':
						if ($v['Setting']['value']) {
							$image = in_array(Utils::getExtension($v['Setting']['value']), ['jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp']);

							if ($image) {
								$img = $this->Html->image('../uploads/settings/'.$v['Setting']['value']);
								echo $this->Html->link($img, '/uploads/settings/'.$v['Setting']['value'], ['class' => 'pop', 'escape' => false]);
							} else {
								echo Router::url('/uploads/settings/'.$v['Setting']['value'], true);
							}
						}
						break;

					case 'percents':
						echo $v['Setting']['value'].'%';
						break;

					default:
						echo $v['Setting']['value'];
				}

				?></td>
			<td class="nb icons">
				<?php

				$downloadable = $v['Setting']['type'] === 'file' && $v['Setting']['value'];

				echo $this->element('admin/action-btn', [
					'buttons' => ['update'],
					'id' => $v['Setting']['id']
				]);

				?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<?= $this->element('admin/paginator') ?>
