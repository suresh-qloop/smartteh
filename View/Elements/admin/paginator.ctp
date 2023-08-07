<?php if (isset($this->Paginator) && intval($this->Paginator->counter(['format' => '%pages%'])) > 1): ?>
	<?php

	$this->Paginator->options(['url' => $this->passedArgs]);

	?>
	<div class="paginator">
		<p>
			<?= $this->Paginator->counter([
				'format' => __d('admin', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
			]) ?>
		</p>
		<div>
			<?php

			echo $this->Paginator->prev('« '.__d('admin', 'Previous'), [], null, ['class' => 'disabled']);

			echo $this->Paginator->numbers(['separator' => false]);

			echo $this->Paginator->next(__d('admin', 'Next').' »', [], null, ['class' => 'disabled']);

			?>
		</div>
	</div>
<?php endif ?>
