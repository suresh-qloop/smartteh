<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Pelago\Emogrifier\CssInliner;

class EmailProcessingHelper extends AppHelper
{
	/**
	 * @param string $layoutFile
	 *
	 * @return void
	 */
	public function afterLayout($layoutFile): void {
		$content = $this->_View->Blocks->get('content');

		$url = $this->getStyleUrl();

		if ($url) {
			$css = $this->getFileContents($url);

			if ($css) {
				$content = CssInliner::fromHtml($content)->inlineCss($css)->render();
			}
		}

		$this->_View->Blocks->set('content', $content);
	}

	/**
	 * @return string|null
	 */
	public function getStyleUrl(): ?string {
		$helper = new AssetCompressHelper(new View());
		$link_tag = $helper->css('email', ['fullBase' => true]);

		preg_match('/href="(.*)"/', $link_tag, $matches);

		return $matches[1] ?? null;
	}

	/**
	 * @param string $url
	 *
	 * @return string|null
	 */
	public function getFileContents(string $url): ?string {
		$client = new Client([
			'verify' => !env('APP_DEBUG')
		]);

		try {
			$response = $client->get($url);

			return $response->getBody()->getContents();
		} catch (GuzzleException $e) {
			return null;
		}
	}
}
