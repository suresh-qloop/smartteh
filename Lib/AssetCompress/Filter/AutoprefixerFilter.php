<?php

App::import('Lib', 'AssetCompress.AssetFilterInterface');
App::import('Vendor', 'Autoprefixer', ['file' => 'vladkens/autoprefixer/lib/Autoprefixer.php']);

class AutoprefixerFilter implements AssetFilterInterface
{
	public function settings($settings) {
	}

	public function input($file, $contents) {
		return $contents;
	}

	public function output($file, $contents) {
		$autoprefixer = new Autoprefixer('last 2 versions');

		return $autoprefixer->compile($contents);
	}
}
