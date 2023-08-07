<?php

App::import('Lib', 'AssetCompress.AssetFilterInterface');
App::import('Vendor', 'CssMinifier', ['file' => 'natxet/CssMin/src/CssMin.php']);

class MinifyCssFilter implements AssetFilterInterface
{
	public function settings($settings) {
	}

	public function input($file, $contents) {
		return $contents;
	}

	public function output($file, $contents) {
		$minifier = new CssMinifier();

		return $minifier->minify($contents);
	}
}
