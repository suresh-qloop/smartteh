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
	public $uses = ['Section', 'Product', 'Category', 'Industry', 'Service', 'Article', 'Portfolio','Categories','Portfolio_images','Product_images','ProductImage'];

	/**
	 * @var array
	 */
	private $langs = [];

	public $site_url  = "https://www.www.localhost/smartteh";

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

		$image_urls = [];
		$image_urls = array_merge($image_urls, $this->productImageUrls());
		$image_urls = array_merge($image_urls, $this->industiresImageUrls());
		$image_urls = array_merge($image_urls, $this->articlesImageUrls());
		$image_urls = array_merge($image_urls, $this->portfoliosImageUrls());
		$image_urls = array_merge($image_urls, $this->servicesImageUrls());

		$sitemapimages = [
			'urlset' => [
				'xmlns:' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
				'xmlns:image' => 'http://www.google.com/schemas/sitemap-image/1.1',
				'url' => $image_urls
			]
		];

		// $xml = Xml::fromArray($sitemap);

		$this->set(compact('sitemap','sitemapimages'));
	}

	private function productImageUrls(): array {
		$image_urls = [];

		$urls_products = $this->Product->find('all', [
			'conditions' => ['enabled' => 1]
		]);

		foreach ($urls_products as $key) {

			$product_id = $key['Product']['id'];
			$category_id = $key['Product']['category_id'];

			$urls_images_by_product_id = $this->Product_images->find('all', [
				'conditions' => ['enabled' => 1,'product_id' => $product_id]
			]);
			$urls_images_by_category =  $this->Categories->find('all', [
				'conditions' => ['enabled' => 1,'id' => $category_id]
			]);

			foreach ($urls_images_by_product_id as $keyex) {

				$image_urls[$product_id]['images'][] = $this->site_url."/uploads/images/products/large/".$keyex['Product_images']['filename'];

			}
			
			$image_urls[$product_id]['href'] = $this->site_url.'/iekartas/'.$urls_images_by_category[0]['Categories']['strid_lv'].'/'.$key["strid_lv"].'';
			
			if (!empty($key["strid_ru"])) {
				$image_urls[$product_id]['href_ru'] = $this->site_url.'/ru/categories/'.$urls_images_by_category[0]['Categories']['strid_ru'].'/'.$key["strid_ru"].'';
			}
			if (!empty($key["strid_es"])) {
				$image_urls[$product_id]['href_es'] = $this->site_url.'/es/categories/'.$urls_images_by_category[0]['Categories']['strid_es'].'/'.$key["strid_es"].'';
			}
			if (!empty($key["strid_de"])) {
				$image_urls[$product_id]['href_de'] = $this->site_url.'/de/categories/'.$urls_images_by_category[0]['Categories']['strid_de'].'/'.$key["strid_de"].'';
			}
			if (!empty($key["strid_en"])) {
				$image_urls[$product_id]['href_en'] = $this->site_url.'/en/categories/'.$urls_images_by_category[0]['Categories']['strid_en'].'/'.$key["strid_en"].'';
			}
		}
		return $image_urls;
	}

	private function relatedLangs(string $lang): array {
		return array_filter($this->langs, static function ($this_lang) use ($lang) {
			return $this_lang !== $lang;
		});
	}

	private function industiresImageUrls(): array {
		$image_urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename_menu';
		$fields[] = 'filename_header';
		$fields[] = 'filename_brick';

		$data = $this->Industry->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $k=>$v) {
			$langs = array_intersect($this->langs, $v['Industry']['translated']);

			foreach ($langs as $lang) {
				$image_url['href'] = 
					Router::url(['lang' => $lang, 'controller' => 'industries', 'action' => 'view', $v['Industry']['strid_' . $lang]], true);
				

				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Industry']['translated']);
					if ($related_langs) {
						$image_url['images'] = [];
						$image_url['images'][] = $this->site_url."/uploads/images/industries/menu/".$v['Industry']['filename_menu'];
						$image_url['images'][] = $this->site_url."/uploads/images/industries/menu/".$v['Industry']['filename_header'];
						$image_url['images'][] = $this->site_url."/uploads/images/industries/menu/".$v['Industry']['filename_brick'];
					}
				}

				$image_urls[] = $image_url;
			}
		}

		return $image_urls;
	}

	private function articlesImageUrls(): array {
		$image_urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename';

		$data = $this->Article->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $k=>$v) {
			$langs = array_intersect($this->langs, $v['Article']['translated']);

			foreach ($langs as $lang) {
				$image_url['href'] = 
					Router::url(['lang' => $lang, 'controller' => 'articles', 'action' => 'view', $v['Article']['strid_' . $lang]], true);
				

				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Article']['translated']);
					if ($related_langs) {
						$image_url['images'] = [];
						$image_url['images'][] = $this->site_url."/uploads/images/articles/thumb/".$v['Article']['filename'];
					}
				}

				$image_urls[] = $image_url;
			}
		}

		return $image_urls;
	}

	private function portfoliosImageUrls(): array {
		$image_urls = [];
		

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename';
		$fields[] = 'filename_wide';

		$data = $this->Portfolio->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $k=>$v) {
			$portfolio_id = $v['Portfolio']['id'];
			$langs = array_intersect($this->langs, $v['Portfolio']['translated']);

			$data_image = $this->Portfolio_images->find('all', [
				'conditions' => ['enabled' => 1,'portfolio_id' => $portfolio_id]
			]);

			foreach ($langs as $lang) {
				$image_url['href'] = 
					Router::url(['lang' => $lang, 'controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_' . $lang]], true);
				

				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Portfolio']['translated']);
					if ($related_langs) {
						$image_url['images'] = [];
						$image_url['images'][] = $this->site_url."/uploads/images/portfolio/large/".$v['Portfolio']['filename'];
						if (!empty($v['Portfolio']['filename_wide'])) {
							$image_url['images'][] = $this->site_url."/uploads/images/portfolio/large/".$v['Portfolio']['filename_wide'];
						}
						foreach ($data_image as $img) {
							$image_url['images'][] = $this->site_url."/uploads/images/portfolio/large/".$img['Portfolio_images']['filename'];
						}
					}
				}

				$image_urls[] = $image_url;
			}
		}

		return $image_urls;
	}

	private function servicesImageUrls(): array {
		$image_urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename_brick';
		$fields[] = 'filename_menu';
		$fields[] = 'filename_mobile';

		$data = $this->Service->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $k=>$v) {
			$langs = array_intersect($this->langs, $v['Service']['translated']);

			foreach ($langs as $lang) {
				$image_url['href'] = 
					Router::url(['lang' => $lang, 'controller' => 'services', 'action' => 'view', $v['Service']['strid_' . $lang]], true);
				

				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Service']['translated']);
					if ($related_langs) {
						$image_url['images'] = [];
						$image_url['images'][] = $this->site_url."/uploads/images/services/thumb/".$v['Service']['filename_brick'];
						$image_url['images'][] = $this->site_url."/uploads/images/services/thumb/".$v['Service']['filename_menu'];
						$image_url['images'][] = $this->site_url."/uploads/images/services/thumb/".$v['Service']['filename_mobile'];
					}
				}

				$image_urls[] = $image_url;
			}
		}

		return $image_urls;
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
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.1',
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
					'changefreq' => 'daily',
					'lastmod'=> date('c', time()),
					'priority'=>'0.9',
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
					'changefreq' => 'daily',
					'lastmod'=> date('c', time()),
					'priority'=>'0.9',
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
					'changefreq' => 'daily',
					'lastmod'=> date('c', time()),
					'priority'=>'0.9',
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
					'changefreq' => 'daily',
					'lastmod'=> date('c', time()),
					'priority'=>'0.9',
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
					'changefreq' => 'daily',
					'lastmod'=> date('c', time()),
					'priority'=>'0.9',
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
					'changefreq' => 'daily',
					'lastmod'=> date('c', time()),
					'priority'=>'0.9',
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
					'changefreq' => 'daily',
					'lastmod'=> date('c', time()),
					'priority'=>'0.9',
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
