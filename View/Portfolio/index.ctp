<?php $this->set('title_for_layout', $page_title = __('Portfolio')) ?>

<div class="container">

	<?php if (!$data): ?>
		<div class="article-container">
			<article class="article">
				<div class="article-body">
					<?= __('Neviens ieraksts vēl nav pievienots') ?>
				</div>
			</article>
		</div>
	<?php endif ?>

	<?php foreach ($data as $k => $v): ?>
		<div class="article-container">
			<article class="article portfolio">
				<div class="text-block">
					<?php
					if ($mobile) {
						echo $this->Html->link('<h2> '.$v['Portfolio']['title_'.$lang].'</h2>', ['controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_'.$lang]], ['escape' => false]);
					} else { ?>
						<h2>
							<?= $v['Portfolio']['title_'.$lang] ?>
						</h2>
					<?php } ?>

					<div class="article-body">
						<?= $this->Html->preprocessText($v['Portfolio']['intro_'.$lang]) ?>

						<p><?= $this->Html->link(__('Lasīt vairāk'), ['controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_'.$lang]]) ?></p>
					</div>
				</div>
				<div class="image-block">
					<?php

					if ($v['Portfolio']['filename']) {

						$alt = "alt=\"\"";

						if (!empty($v['Portfolio']['alt_'.$lang])) {
							$alt = "alt=\"".$v['Portfolio']['alt_'.$lang]."\"";
						}
						echo $this->Html->link('<img src="/uploads/images/portfolio/'.$v['Portfolio']['filename'].'" '.$alt.' />', ['controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_'.$lang]], ['escape' => false]);
					}
					?>

				</div>

			</article>
		</div>
	<?php endforeach ?>

	<?= $this->element('paginator') ?>
</div>
