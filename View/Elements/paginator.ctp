<?php if (isset($this->Paginator) && intval($this->Paginator->counter(['format' => '%pages%'])) > 1): ?>
	<div class="paginator">
		<?php

		$this->Paginator->options([
			'url' => array_merge($this->passedArgs, ['?' => $this->request->query, 'sort' => false]),

		]);

		echo $this->Paginator->prev('←', [], null, ['class' => 'disabled']);

		echo $this->Paginator->numbers(['separator' => false]);

		echo $this->Paginator->next('→', [], null, ['class' => 'disabled']);

		?>
	</div>
<?php endif ?>
