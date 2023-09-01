<?php

App::uses('AppController', 'Controller');
App::uses('Router', 'Routing');

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
		// $urls = array_merge($urls, $this->moduleUrls('services'));
		$urls = array_merge($urls, $this->moduleUrls('article'));
		$urls = array_merge($urls, $this->moduleUrls('portfolio'));
		$urls = array_merge($urls, $this->sectionUrls());
		$urls = array_merge($urls, $this->categoriesUrls());
		$urls = array_merge($urls, $this->industriesUrls());
		$urls = array_merge($urls, $this->productsUrls());
		// $urls = array_merge($urls, $this->servicesUrls());
		// $urls = array_merge($urls, $this->articlesUrls());
		$urls = array_merge($urls, $this->portfoliosUrls());

		$timex = date('Y-m-d',time());
		$filename = $_SERVER['DOCUMENT_ROOT']."/sitemap-index.xml";

				
		$data = '<?xml version="1.0" encoding="UTF-8"?>
		
			<sitemapindex xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
			
			<sitemap>
					<loc>'.Router::url('/', true).'/sitemap-general.xml</loc>
					<lastmod>'.$timex.'</lastmod>
			</sitemap>
			
			<sitemap>
					<loc>'.Router::url('/', true).'/sitemap-images.xml</loc>
					<lastmod>'.$timex.'</lastmod>
			</sitemap>
			
			<sitemap>
					<loc>'.Router::url('/', true).'/sitemap-posts.xml</loc>
					<lastmod>'.$timex.'</lastmod>
			</sitemap>
			
			</sitemapindex>';
		 file_put_contents($filename, $data);
			
		// general urls
		$html_gen = '<?xml version="1.0" encoding="UTF-8"?>';
		$html_gen .= '
		<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
			xmlns:xhtml="https://www.w3.org/1999/xhtml" xmlns:hreflang="https://www.w3.org/1999/xhtml/rel">';

		foreach ($urls as $url) {

			$html_gen .= '
				<url>
					<loc>'.$url['loc'].'</loc>';
		foreach ($url['xhtml:link'] as $alternate) {
			$html_gen .='
					<xhtml:link rel="' . htmlspecialchars($alternate['@rel']) . '" hreflang="' . htmlspecialchars($alternate['@hreflang']) . '" href="' . htmlspecialchars($alternate['@href']) . '" />';
		}
		$html_gen .='
					<lastmod>'.date("d-m-Y h:i:s", strtotime($url['lastmod'])).'</lastmod>
				</url>';
		}

		$html_gen .= '
		</urlset>';

		file_put_contents( $_SERVER['DOCUMENT_ROOT']."/sitemap-general.xml", $html_gen);

		// images urls
		$image_urls = [];
		$image_urls = array_merge($image_urls, $this->productImageUrls());
		$image_urls = array_merge($image_urls, $this->industiresImageUrls());
		$image_urls = array_merge($image_urls, $this->articlesImageUrls());
		$image_urls = array_merge($image_urls, $this->portfoliosImageUrls());
		$image_urls = array_merge($image_urls, $this->servicesImageUrls());

		$html_image = '<?xml version="1.0" encoding="UTF-8"?>';
		$html_image .= '
		<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
			xmlns:image= "https://www.google.com/schemas/sitemap-image/1.1">';

		foreach ($image_urls as $image_url) {

		$html_image .= '
		<url>
			<loc>'.$image_url['href'].'</loc>';
		foreach ($image_url['images'] as $img) {
		$html_image .='
			<image:image>
				<image:loc>'.$img.'</image:loc>
			</image:image>';
		}
		$html_image .='
		</url>';
		}

		$html_image .= '
		</urlset>';

		file_put_contents( $_SERVER['DOCUMENT_ROOT']."/sitemap-images.xml", $html_image);

		// post or articals urls
		$post_urls = [];
		$post_urls = array_merge($post_urls, $this->articlesUrls());

		$html_post = '<?xml version="1.0" encoding="UTF-8"?>';
		$html_post .= '
		<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
			xmlns:xhtml="https://www.w3.org/1999/xhtml" xmlns:hreflang="https://www.w3.org/1999/xhtml/rel">';

		foreach ($post_urls as $url) {

			$html_post .= '
				<url>
					<loc>'.$url['loc'].'</loc>';
		foreach ($url['xhtml:link'] as $alternate) {
			$html_post .='
					<xhtml:link rel="' . htmlspecialchars($alternate['@rel']) . '" hreflang="' . htmlspecialchars($alternate['@hreflang']) . '" href="' . htmlspecialchars($alternate['@href']) . '" />';
		}
		$html_post .='
					<lastmod>'.date("d-m-Y h:i:s", strtotime($url['lastmod'])).'</lastmod>
				</url>';
		}

		$html_post .= '
		</urlset>';

		file_put_contents( $_SERVER['DOCUMENT_ROOT']."/sitemap-posts.xml", $html_post);
	}

	private function productImageUrls(): array {
		$image_urls = [];

		$fields = array_map(static function ($lang) {
			return 'strid_' . $lang;
		}, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename';
		$fields[] = 'category_id';

		$data = $this->Product->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);

		foreach ($data as $k=>$v) {
			$product_id = $v['Product']['id'];
			$category_id = $v['Product']['category_id'];
			$langs = array_intersect($this->langs, $v['Product']['translated']);

			$data_image = $this->Product_images->find('all', [
				'conditions' => ['enabled' => 1,'product_id' => $product_id]
			]);

			foreach ($langs as $lang) {
				$image_url['href'] = 
					Router::url(['lang' => $lang, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_' . $lang]], true);
				
				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Product']['translated']);
					if ($related_langs) {
						$image_url['images'] = [];
						$image_url['images'][] = Router::url('/', true)."uploads/images/products/small/".$v['Product']['filename'];
						foreach ($data_image as $img) {
							$image_url['images'][] = Router::url('/', true)."uploads/images/products/medium/".$img['Product_images']['filename'];
						}
					}
				}

				$image_urls[] = $image_url;
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
						$image_url['images'][] = Router::url('/', true)."uploads/images/industries/menu/".$v['Industry']['filename_menu'];
						$image_url['images'][] = Router::url('/', true)."uploads/images/industries/header/".$v['Industry']['filename_header'];
						$image_url['images'][] = Router::url('/', true)."uploads/images/industries/brick/".$v['Industry']['filename_brick'];
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
						$image_url['images'][] = Router::url('/', true)."uploads/images/articles/thumb/".$v['Article']['filename'];
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
						$image_url['images'][] = Router::url('/', true)."uploads/images/portfolio/".$v['Portfolio']['filename'];
						if (!empty($v['Portfolio']['filename_wide'])) {
							$image_url['images'][] = Router::url('/', true)."uploads/images/portfolio/wide/".$v['Portfolio']['filename_wide'];
						}
						foreach ($data_image as $img) {
							$image_url['images'][] = Router::url('/', true)."uploads/images/portfolio/large/".$img['Portfolio_images']['filename'];
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
						$image_url['images'][] = Router::url('/', true)."uploads/images/services/brick/".$v['Service']['filename_brick'];
						$image_url['images'][] = Router::url('/', true)."uploads/images/services/menu/".$v['Service']['filename_menu'];
						$image_url['images'][] = Router::url('/', true)."uploads/images/services/mobile/".$v['Service']['filename_mobile'];
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

		if (in_array("en", $this->langs)) {
			$la = 'en';
		} elseif (in_array("lv", $this->langs)) {
			$la = 'lv';
		} elseif (in_array("ru", $this->langs)) {
			$la = 'ru';
		} elseif (in_array("es", $this->langs)) {
			$la = 'es';
		} else {
			$la = 'de';
		}

		$url = [
			'loc' => rtrim(Router::url(['lang' => $la, 'controller' => $controller, 'action' => 'index'], true), '/'),
			'changefreq' => 'daily',
			'lastmod'=> date('c', time()),
			'priority'=>'0.1',
		];

		$url['xhtml:link'] = [];
		foreach ($this->langs as $lang) {
			$url['xhtml:link'][] = [
				'@rel' => 'alternate',
				'@hreflang' => $lang,
				'@href' => Router::url(['lang' => $lang, 'controller' => $controller, 'action' => 'index'], true)
			];
		}
		$urls[] = $url;		
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

			if (in_array("en", $langs)) {
				$la = 'en';
			} elseif (in_array("lv", $langs)) {
				$la = 'lv';
			} elseif (in_array("ru", $langs)) {
				$la = 'ru';
			} elseif (in_array("es", $langs)) {
				$la = 'es';
			} else {
				$la = 'de';
			}

			$url = [
				'loc' => Router::url(['lang' => $la, 'controller' => 'sections', 'action' => 'view', $v['Section']['strid_' . $la]], true),
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.9',
			];

			$url['xhtml:link'] = [];
			foreach ($langs as $lang) {
				$url['xhtml:link'][] = [
					'@rel' => 'alternate',
					'@hreflang' => $lang,
					'@href' => Router::url(['lang' => $lang, 'controller' => 'sections', 'action' => 'view', $v['Section']['strid_' . $lang]], true)
				];
			}
			$urls[] = $url;
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

			if (in_array("en", $langs)) {
				$la = 'en';
			} elseif (in_array("lv", $langs)) {
				$la = 'lv';
			} elseif (in_array("ru", $langs)) {
				$la = 'ru';
			} elseif (in_array("es", $langs)) {
				$la = 'es';
			} else {
				$la = 'de';
			}

			$url = [
				'loc' => Router::url(['lang' => $la, 'controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$la]], true),
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.9',
			];

			$url['xhtml:link'] = [];
			foreach ($langs as $lang) {
				$url['xhtml:link'][] = [
					'@rel' => 'alternate',
					'@hreflang' => $lang,
					'@href' => Router::url(['lang' => $lang, 'controller' => 'categories', 'action' => 'view', $v['Category']['strid_' . $lang]], true)
				];
			}
			$urls[] = $url;
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

			if (in_array("en", $langs)) {
				$la = 'en';
			} elseif (in_array("lv", $langs)) {
				$la = 'lv';
			} elseif (in_array("ru", $langs)) {
				$la = 'ru';
			} elseif (in_array("es", $langs)) {
				$la = 'es';
			} else {
				$la = 'de';
			}

			$url = [
				'loc' => Router::url(['lang' => $la, 'controller' => 'industries', 'action' => 'view', $v['Industry']['strid_' . $la]], true),
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.9',
			];

			$url['xhtml:link'] = [];
			foreach ($langs as $lang) {
				$url['xhtml:link'][] = [
					'@rel' => 'alternate',
					'@hreflang' => $lang,
					'@href' => Router::url(['lang' => $lang, 'controller' => 'industries', 'action' => 'view', $v['Industry']['strid_' . $lang]], true)
				];
			}
			$urls[] = $url;
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

			if (in_array("en", $langs)) {
				$la = 'en';
			} elseif (in_array("lv", $langs)) {
				$la = 'lv';
			} elseif (in_array("ru", $langs)) {
				$la = 'ru';
			} elseif (in_array("es", $langs)) {
				$la = 'es';
			} else {
				$la = 'de';
			}

			$url = [
				'loc' => Router::url(['lang' => $la, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_' . $la]], true),
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.9',
			];

			$url['xhtml:link'] = [];
			foreach ($langs as $lang) {
				$url['xhtml:link'][] = [
					'@rel' => 'alternate',
					'@hreflang' => $lang,
					'@href' => Router::url(['lang' => $lang, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_' . $lang]], true)
				];
			}
			$urls[] = $url;
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

			if (in_array("en", $langs)) {
				$la = 'en';
			} elseif (in_array("lv", $langs)) {
				$la = 'lv';
			} elseif (in_array("ru", $langs)) {
				$la = 'ru';
			} elseif (in_array("es", $langs)) {
				$la = 'es';
			} else {
				$la = 'de';
			}

			$url = [
				'loc' => Router::url(['lang' => $la, 'controller' => 'services', 'action' => 'view', $v['Service']['strid_' . $la]], true),
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.9',
			];

			$url['xhtml:link'] = [];
			foreach ($langs as $lang) {
				$url['xhtml:link'][] = [
					'@rel' => 'alternate',
					'@hreflang' => $lang,
					'@href' => Router::url(['lang' => $lang, 'controller' => 'services', 'action' => 'view', $v['Service']['strid_' . $lang]], true)
				];
			}
			$urls[] = $url;
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

			if (in_array("en", $langs)) {
				$la = 'en';
			} elseif (in_array("lv", $langs)) {
				$la = 'lv';
			} elseif (in_array("ru", $langs)) {
				$la = 'ru';
			} elseif (in_array("es", $langs)) {
				$la = 'es';
			} else {
				$la = 'de';
			}

			$url = [
				'loc' => Router::url(['lang' => $la, 'controller' => 'articles', 'action' => 'view', $v['Article']['strid_' . $la]], true),
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.9',
			];

			$url['xhtml:link'] = [];
			foreach ($langs as $lang) {
				$url['xhtml:link'][] = [
					'@rel' => 'alternate',
					'@hreflang' => $lang,
					'@href' => Router::url(['lang' => $lang, 'controller' => 'articles', 'action' => 'view', $v['Article']['strid_' . $lang]], true)
				];
			}
			$urls[] = $url;
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
			
			if (in_array("en", $this->langs)) {
				$la = 'en';
			} elseif (in_array("lv", $this->langs)) {
				$la = 'lv';
			} elseif (in_array("ru", $this->langs)) {
				$la = 'ru';
			} elseif (in_array("es", $this->langs)) {
				$la = 'es';
			} else {
				$la = 'de';
			}

			$url = [
				'loc' => Router::url(['lang' => $la, 'controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_' . $la]], true),
				'changefreq' => 'daily',
				'lastmod'=> date('c', time()),
				'priority'=>'0.9',
			];

			$url['xhtml:link'] = [];
			foreach ($langs as $lang) {
				$url['xhtml:link'][] = [
					'@rel' => 'alternate',
					'@hreflang' => $lang,
					'@href' => Router::url(['lang' => $lang, 'controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_' . $lang]], true)
				];
			}
			$urls[] = $url;
		}
		return $urls;
	}
}
