<?php

App::uses('AppController', 'Controller');

class SitemapController extends AppController
{
	/**
	 * @var string
	 */
	public $name = 'Sitemap';

	/**
	 * @var array
	 */
	public $uses = ['Section', 'Product', 'Category', 'Industry', 'Service', 'Article', 'Portfolio'];

	/**
	 * @var array
	 */
	private $langs = [];

	/**
	 * @var bool
	 */
	private $output_related_langs = true;

	/**
	 * Output XML sitemap.
	 *
	 * @return void
	 */
	public function index(): void {
		$this->langs = array_keys(Configure::read('Languages.all'));

		$urls = [];

		$urls = array_merge($urls, $this->moduleUrls('start'));
		$urls = array_merge($urls, $this->moduleUrls('industries'));
		$urls = array_merge($urls, $this->moduleUrls('categories'));
		$urls = array_merge($urls, $this->moduleUrls('services'));
		$urls = array_merge($urls, $this->moduleUrls('article'));
		$urls = array_merge($urls, $this->moduleUrls('portfolio'));
		$urls = array_merge($urls, $this->sectionUrls());
		$urls = array_merge($urls, $this->categoriesUrls());
		$urls = array_merge($urls, $this->industriesUrls());
		$urls = array_merge($urls, $this->productsUrls());
		$urls = array_merge($urls, $this->servicesUrls());
		$urls = array_merge($urls, $this->articlesUrls());
		$urls = array_merge($urls, $this->portfoliosUrls());


		$sitemap = [
			'urlset' => [
				'xmlns:' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
				'xmlns:xhtml' => 'http://www.w3.org/1999/xhtml',
				'url' => $urls
			]
		];

		// $xml = Xml::fromArray($sitemap);

		$this->set(compact('sitemap'));
	}

	/**
	 * @param string $controller
	 *
	 * @return array
	 */
	private function moduleUrls(string $controller): array {
		$urls = [];
		foreach ($this->langs as $lang) {
			$url = [
				'loc' => rtrim(Router::url(['lang' => $lang, 'controller' => $controller, 'action' => 'index'], true), '/'),
				'changefreq' => 'daily'
			];

			if ($this->output_related_langs) {
				$url['xhtml:link'] = [];
				foreach ($this->relatedLangs($lang) as $related_lang) {
					$url['xhtml:link'][] = [
						'@rel' => 'alternate',
						'@hreflang' => $related_lang,
						'@href' => Router::url(['lang' => $related_lang, 'controller' => $controller, 'action' => 'index'], true)
					];
				}
			}

			$urls[] = $url;
		}

		return $urls;
	}

	/**
	 * @return array
	 */
	private function sectionUrls(): array {
		$urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';

		$data = $this->Section->find('all', [
			'fields' => $fields
		]);

		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Section']['translated']);

			foreach ($langs as $lang) {
				$urls[] = [
					'loc' => Router::url(['lang' => $lang, 'controller' => 'sections', 'action' => 'view', $v['Section']['strid_' . $lang]], true),
					'changefreq' => 'daily'
				];
			}
		}

		return $urls;
	}

	/**
	 * @return array
	 */
	private function categoriesUrls(): array {
		$urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';

		$data = $this->Category->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Category']['translated']);

			foreach ($langs as $lang) {
				$url = [
					'loc' => Router::url(['lang' => $lang, 'controller' => 'categories', 'action' => 'view', $v['Category']['strid_' . $lang]], true),
					'changefreq' => 'daily'
				];

				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Category']['translated']);
					if ($related_langs) {
						$url['xhtml:link'] = [];
						foreach ($related_langs as $related_lang) {
							$url['xhtml:link'][] = [
								'@rel' => 'alternate',
								'@hreflang' => $related_lang,
								'@href' => Router::url(['lang' => $related_lang, 'controller' => 'categories', 'action' => 'view', $v['Category']['strid_' . $related_lang]], true)
							];
						}
					}
				}

				$urls[] = $url;
			}
		}

		return $urls;
	}

	/**
	 * @param string $lang
	 *
	 * @return array
	 */
	private function relatedLangs(string $lang): array {
		return array_filter($this->langs, static function ($this_lang) use ($lang) {
			return $this_lang !== $lang;
		});
	}

	/**
	 * @return array
	 */
	private function industriesUrls(): array {
		$urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';

		$data = $this->Industry->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Industry']['translated']);

			foreach ($langs as $lang) {
				$url = [
					'loc' => Router::url(['lang' => $lang, 'controller' => 'industries', 'action' => 'view', $v['Industry']['strid_' . $lang]], true),
					'changefreq' => 'daily'
				];

				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Industry']['translated']);
					if ($related_langs) {
						$url['xhtml:link'] = [];
						foreach ($related_langs as $related_lang) {
							$url['xhtml:link'][] = [
								'@rel' => 'alternate',
								'@hreflang' => $related_lang,
								'@href' => Router::url(['lang' => $related_lang, 'controller' => 'industries', 'action' => 'view', $v['Industry']['strid_' . $related_lang]], true)
							];
						}
					}
				}

				$urls[] = $url;
			}
		}

		return $urls;
	}

	/**
	 * @return array
	 */
	private function productsUrls(): array {
		$urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';

		$data = $this->Product->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields,
		]);

		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Product']['translated']);

			foreach ($langs as $lang) {
				$url = [
					'loc' => Router::url(['lang' => $lang, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_' . $lang]], true),
					'changefreq' => 'daily'
				];

				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Product']['translated']);
					if ($related_langs) {
						$url['xhtml:link'] = [];
						foreach ($related_langs as $related_lang) {
							$url['xhtml:link'][] = [
								'@rel' => 'alternate',
								'@hreflang' => $related_lang,
								'@href' => Router::url(['lang' => $related_lang, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_' . $related_lang]], true)
							];
						}
					}
				}

				$urls[] = $url;
			}
		}

		return $urls;
	}

	private function servicesUrls(): array {
		$urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';

		$data = $this->Service->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Service']['translated']);


			foreach ($langs as $lang) {
				$url = [
					'loc' => Router::url(['lang' => $lang, 'controller' => 'services', 'action' => 'view', $v['Service']['strid_' . $lang]], true),
					'changefreq' => 'daily'
				];

				if ($this->output_related_langs) {

					$related_langs = array_intersect($this->relatedLangs($lang), $v['Service']['translated']);
					if ($related_langs) {
						$url['xhtml:link'] = [];
						foreach ($related_langs as $related_lang) {
							$url['xhtml:link'][] = [
								'@rel' => 'alternate',
								'@hreflang' => $related_lang,
								'@href' => Router::url(['lang' => $related_lang, 'controller' => 'services', 'action' => 'view', $v['Service']['strid_' . $related_lang]], true)
							];
						}
					}
				}

				$urls[] = $url;
			}
		}

		return $urls;
	}

	private function articlesUrls(): array {
		$urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';

		$data = $this->Article->find('all', [
			'fields' => $fields
		]);

		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Article']['translated']);


			foreach ($langs as $lang) {
				$url = [
					'loc' => Router::url(['lang' => $lang, 'controller' => 'articles', 'action' => 'view', $v['Article']['strid_' . $lang]], true),
					'changefreq' => 'daily'
				];

				if ($this->output_related_langs) {

					$related_langs = array_intersect($this->relatedLangs($lang), $v['Article']['translated']);
					if ($related_langs) {
						$url['xhtml:link'] = [];
						foreach ($related_langs as $related_lang) {
							$url['xhtml:link'][] = [
								'@rel' => 'alternate',
								'@hreflang' => $related_lang,
								'@href' => Router::url(['lang' => $related_lang, 'controller' => 'articles', 'action' => 'view', $v['Article']['strid_' . $related_lang]], true)
							];
						}
					}
				}

				$urls[] = $url;
			}
		}

		return $urls;
	}

	private function portfoliosUrls(): array {
		$urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';

		$data = $this->Portfolio->find('all', [
			'fields' => $fields
		]);

		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Portfolio']['translated']);

			foreach ($langs as $lang) {
				$url = [
					'loc' => Router::url(['lang' => $lang, 'controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_' . $lang]], true),
					'changefreq' => 'daily'
				];

				if ($this->output_related_langs) {

					$related_langs = array_intersect($this->relatedLangs($lang), $v['Portfolio']['translated']);
					if ($related_langs) {
						$url['xhtml:link'] = [];
						foreach ($related_langs as $related_lang) {
							$url['xhtml:link'][] = [
								'@rel' => 'alternate',
								'@hreflang' => $related_lang,
								'@href' => Router::url(['lang' => $related_lang, 'controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_' . $related_lang]], true)
							];
						}
					}
				}

				$urls[] = $url;
			}
		}

		return $urls;
	}
}
