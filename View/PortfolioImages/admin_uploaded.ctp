<?php if ($response == 'list'): ?>
	<tr>
		<td class="nb">
			<a href="/uploads/images/portfolio/large/<?= $data['PortfolioImage']['filename'] ?>" class="pop">
				<?= $this->Html->uploadedImage('portfolio/preview/'.$data['PortfolioImage']['filename'], ['width' => 123]) ?>
			</a>
		</td>
		<td>
			<?= $this->Form->input('title', [
				'name' => 'data[PortfolioImage]['.$data['PortfolioImage']['id'].'][title_'.$lang.']',
				'value' => $data['PortfolioImage']['title_'.$lang],
				'label' => false
			]) ?>
		</td>
		<td>
			<?= $this->Form->input('alt', [
				'name' => 'data[PortfolioImage]['.$data['PortfolioImage']['id'].'][alt_'.$lang.']',
				'value' => $data['PortfolioImage']['alt_'.$lang],
				'label' => false
			]) ?>
		</td>
		<td class="nb icons">
			<?= $this->element('admin/action-btn', [
				'buttons' => ['moveup', 'movedown', 'delete'],
				'id' => $data['PortfolioImage']['id']
			]) ?>
		</td>
	</tr>
<?php else: ?>
	<li data-id="<?= $data['PortfolioImage']['id'] ?>">
		<a href="/uploads/images/portfolio/large/<?= $data['PortfolioImage']['filename'] ?>" class="pop">
			<?= $this->Html->uploadedImage('portfolio/preview/'.$data['PortfolioImage']['filename'], ['width' => 123]) ?>
		</a>

		<div class="toolbar">
			<?= $this->Form->input('id.'.$data['PortfolioImage']['id'], ['type' => 'checkbox', 'label' => '', 'div' => 'input checkbox no-label']) ?>
			<?= $this->Html->link('', ['controller' => 'portfolio_images', 'action' => 'delete', $data['PortfolioImage']['id']], ['class' => 'fa fa-trash-o confirm', 'title' => __d('admin', 'delete')]) ?>
		</div>
	</li>
<?php endif ?>
