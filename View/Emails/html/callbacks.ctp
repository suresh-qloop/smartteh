<table>
	<tr>
		<th>Vārds:</th>
		<td><?= $data['Callbacks']['name'] ?></td>
	</tr>
	<tr>
		<th>Uzņēmums:</th>
		<td><?= $data['Callbacks']['company'] ?></td>
	</tr>
	<tr>
		<th>E-pasts:</th>
		<td><?= $data['Callbacks']['email'] ?: '&mdash;' ?></td>
	</tr>
	<tr>
		<th>Telefons:</th>
		<td><?= $data['Callbacks']['phone'] ?: '&mdash;' ?></td>
	</tr>
	<?php if (!empty($data['Product']['id'])): ?>
		<tr>
			<th>Prece:</th>
			<td>
				<a href="<?= Router::url(['admin' => false, 'controller' => 'products', 'action' => 'view', $data['Product']['strid_lv']], true) ?>">
					<?= $data['Product']['title_lv'] ?>
				</a>
			</td>
		</tr>
	<?php endif ?>
	<tr>
		<th>Jautājums:</th>
		<td><?= nl2br(h($data['Callbacks']['question'])) ?></td>
	</tr>
</table>
