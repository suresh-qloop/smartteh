<table>
	<tr>
		<th>Uzņēmums:</th>
		<td><?= $data['Contacts']['name'] ?></td>
	</tr>
	<tr>
		<th>E-pasts:</th>
		<td><?= $data['Contacts']['email'] ?: '&mdash;' ?></td>
	</tr>
	<tr>
		<th>Telefons:</th>
		<td><?= $data['Contacts']['phone'] ?: '&mdash;' ?></td>
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
		<th>Teksts:</th>
		<td><?= nl2br(h($data['Contacts']['text'])) ?></td>
	</tr>
</table>
