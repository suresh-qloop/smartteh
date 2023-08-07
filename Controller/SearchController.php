<?php

App::uses('AppController', 'Controller');

/**
 * Search
 */
class SearchController extends AppController
{
	public $name = 'Search';

	public $uses = ['Product', 'Portfolio'];

	/**
	 * Search products (ajax version)
	 *
	 * @return void
	 */
	public function autosuggest(): void {
		if (empty($this->request->query['q'])) {
			throw new BadRequestException();
		}

		$keyword = $this->request->query['q'];

		if (strlen($keyword) < 2) {
			throw new BadRequestException();
		}

		$products = $this->Product->autosuggest($this->lang, $keyword, 7);
		$portfolio = $this->Portfolio->autosuggest($this->lang, $keyword, 7);

		$this->set(compact('products', 'portfolio', 'keyword'));
	}
}
