<?php

$url = Router::url(['lang' => $lang, 'controller' => 'products', 'action' => 'view', $data['Product']['strid_'.$lang]], true);

?>
<?php if ($intro): ?>
	<?= $intro ?>
	<br /><br />
<?php endif ?>

<h1><?= $data['Product']['title_'.$lang] ?></h1>

<p><?= $data['Product']['description_'.$lang] ?></p>

<p><?= $this->Html->link(__('Lasīt vairāk.'), $url) ?></p>
