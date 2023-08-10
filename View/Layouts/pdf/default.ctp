<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<?= $this->AssetCompress->css('pdf', ['fullBase' => true]) ?>
</head>
<body>

<div class="container">
	<?= $content_for_layout ?>
</div>

</body>
</html>
