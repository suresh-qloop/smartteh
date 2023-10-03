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
		usort($this->langs, function ($a, $b) {
			if ($a === 'en') {
				return -1; // 'en' comes first
			} elseif ($b === 'en') {
				return 1;  // 'en' comes first
			} else {
				return 0;  // Keep the original order for other elements
				return -1;
			}
		
			if ($b === 'en') {
				return 1;
			}
		
			return 0;
		});
		$urls = [];
		$urls = array_merge($urls, $this->moduleUrls('start'));
		$urls = array_merge($urls, $this->moduleUrls('industries'));
		$urls = array_merge($urls, $this->moduleUrls('categories'));		
		$urls = array_merge($urls, $this->moduleUrls('article'));
		$urls = array_merge($urls, $this->moduleUrls('portfolio'));
		$urls = array_merge($urls, $this->sectionUrls());
		$urls = array_merge($urls, $this->categoriesUrls());
		$urls = array_merge($urls, $this->industriesUrls());
		$urls = array_merge($urls, $this->productsUrls());
		$urls = array_merge($urls, $this->portfoliosUrls());
			
		// general urls
		$html_gen = '<?xml version="1.0" encoding="UTF-8"?>';
		$html_gen .= '
		<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
			xmlns:xhtml="https://www.w3.org/1999/xhtml" xmlns:hreflang="https://www.w3.org/1999/xhtml/rel">';
		foreach ($urls as $url) {
			$html_gen .= '<url>';
			$html_gen .= '<loc>'.$url['loc'].'</loc>';
			foreach ($url['xhtml:link'] as $alternate) {
				$html_gen .='
					<xhtml:link rel="'.htmlspecialchars($alternate['@rel']).'" hreflang="'.htmlspecialchars($alternate['@hreflang']).'" href="'.htmlspecialchars($alternate['@href']).'" />';
			}	
			if (isset($url['lastmod'])) {
				$html_gen .= '<lastmod>'.$url['lastmod'].'</lastmod>';		
			}
			$html_gen .= '</url>';
		}		
		$html_gen .= '</urlset>';

		$sitemap_general_file_name = $_SERVER['DOCUMENT_ROOT'].'/sitemap-general.xml';
			
		if (file_put_contents($sitemap_general_file_name, $html_gen) === false) {
			throw new Exception('Unable to write sitemap to '.$sitemap_general_file_name);
		}		
		// images urls
		$image_urls = [];
		$image_urls = array_merge($image_urls, $this->productImageUrls());
		$image_urls = array_merge($image_urls, $this->industiresImageUrls());
		$image_urls = array_merge($image_urls, $this->articlesImageUrls());
		$image_urls = array_merge($image_urls, $this->portfoliosImageUrls());
		$image_urls = array_merge($image_urls, $this->servicesImageUrls());
		$html_image = '<?xml version="1.0" encoding="UTF-8"?>';

		$html_image .= '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image= "https://www.google.com/schemas/sitemap-image/1.1">';
		foreach ($image_urls as $image_url) {
			$html_image .= '<url>';
			$html_image .= '<loc>'.$image_url['href'].'</loc>';
			foreach ($image_url['images'] as $img) {
				$html_image .='<image:image><image:loc>'.$img.'</image:loc></image:image>';
			}
			$html_image .='</url>';
		}
		$html_image .= '</urlset>';
		
		$sitemap_images_file_name = $_SERVER['DOCUMENT_ROOT'].'/sitemap-images.xml';
			
		if (@file_put_contents($sitemap_images_file_name, $html_image) === false) {
			throw new Exception('Unable to write sitemap to '.$sitemap_images_file_name);
		}		
		// post or articals urls
		$post_urls = [];
		$post_urls = array_merge($post_urls, $this->articlesUrls());
		
		$html_post = '<?xml version="1.0" encoding="UTF-8"?>';
		$html_post .= '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"	xmlns:xhtml="https://www.w3.org/1999/xhtml" xmlns:hreflang="https://www.w3.org/1999/xhtml/rel">';
		foreach ($post_urls as $url) {
			$html_post .= '<url><loc>'.$url['loc'].'</loc>';
			foreach ($url['xhtml:link'] as $alternate) {
				$html_post .='<xhtml:link rel="'.htmlspecialchars($alternate['@rel']).'" hreflang="'.htmlspecialchars($alternate['@hreflang']).'" href="'.htmlspecialchars($alternate['@href']).'" />';
			}
			$html_post .='<lastmod>'.$url['lastmod'].'</lastmod>';
			$html_post .='</url>';
		}
		$html_post .= '</urlset>';

		try {
			$result = file_put_contents( $_SERVER['DOCUMENT_ROOT']."/sitemap-posts.xml", $html_post);
		$sitemap_posts_file_name = $_SERVER['DOCUMENT_ROOT'].'/sitemap-posts.xml';
			if ($result === false) {
				throw new Exception("Unable to write to the file.");
			}
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		} 
		if (@file_put_contents($sitemap_posts_file_name, $html_post) === false) {
			throw new Exception('Unable to write sitemap to '.$sitemap_posts_file_name);
		}				
	}
	private function productImageUrls(): array {
		$image_urls = [];
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename';
		$fields[] = 'category_id';
		$data = $this->Product->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
			$product_id = $v['Product']['id'];
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
						$image_url['images'][] = Router::url('/', true).'uploads/images/products/small/'.$v['Product']['filename'];
						foreach ($data_image as $img) {
							$image_url['images'][] = Router::url('/', true)."uploads/images/products/medium/".$img['Product_images']['filename'];
							$image_url['images'][] = Router::url('/', true).'uploads/images/products/medium/'.$img['Product_images']['filename'];
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
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename_menu';
		$fields[] = 'filename_header';
		$fields[] = 'filename_brick';
		$data = $this->Industry->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
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
						$image_url['images'][] = Router::url('/', true).'uploads/images/industries/menu/'.$v['Industry']['filename_menu'];
						$image_url['images'][] = Router::url('/', true).'uploads/images/industries/header/'.$v['Industry']['filename_header'];
						$image_url['images'][] = Router::url('/', true).'uploads/images/industries/brick/'.$v['Industry']['filename_brick'];
					}
				}
				$image_urls[] = $image_url;
			}
		}
		return $image_urls;
	}
	private function articlesImageUrls(): array {
		$image_urls = [];
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename';
		$data = $this->Article->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Article']['translated']);
			foreach ($langs as $lang) {
				$image_url['href'] = 
					Router::url(['lang' => $lang, 'controller' => 'articles', 'action' => 'view', $v['Article']['strid_' . $lang]], true);
				
				if ($this->output_related_langs) {
					$related_langs = array_intersect($this->relatedLangs($lang), $v['Article']['translated']);
					if ($related_langs) {
						$image_url['images'] = [];
						$image_url['images'][] = Router::url('/', true)."uploads/images/articles/thumb/".$v['Article']['filename'];
						$image_url['images'][] = Router::url('/', true).'uploads/images/articles/thumb/'.$v['Article']['filename'];
					}
				}
				$image_urls[] = $image_url;
			}
		}
		return $image_urls;
	}
	private function portfoliosImageUrls(): array {
		$image_urls = [];
		
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename';
		$fields[] = 'filename_wide';
		$data = $this->Portfolio->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
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
						$image_url['images'][] = Router::url('/', true).'uploads/images/portfolio/'.$v['Portfolio']['filename'];
						if (!empty($v['Portfolio']['filename_wide'])) {
							$image_url['images'][] = Router::url('/', true)."uploads/images/portfolio/wide/".$v['Portfolio']['filename_wide'];
							$image_url['images'][] = Router::url('/', true).'uploads/images/portfolio/wide/'.$v['Portfolio']['filename_wide'];
						}
						foreach ($data_image as $img) {
							$image_url['images'][] = Router::url('/', true)."uploads/images/portfolio/large/".$img['Portfolio_images']['filename'];
							$image_url['images'][] = Router::url('/', true).'uploads/images/portfolio/large/'.$img['Portfolio_images']['filename'];
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
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'id';
		$fields[] = 'filename_brick';
		$fields[] = 'filename_menu';
		$fields[] = 'filename_mobile';
		$data = $this->Service->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
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
						$image_url['images'][] = Router::url('/', true).'uploads/images/services/brick/'.$v['Service']['filename_brick'];
						$image_url['images'][] = Router::url('/', true).'uploads/images/services/menu/'.$v['Service']['filename_menu'];
						$image_url['images'][] = Router::url('/', true).'uploads/images/services/mobile/'.$v['Service']['filename_mobile'];
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
		if ($controller === 'article') {
			$controller = 'blog';
		}
		$language = $this->selectLocLanguage($this->langs);		
		$url = [
			'loc' => rtrim(Router::url(['lang' => $language, 'controller' => $controller, 'action' => 'index'], true), '/'),			
			'lastmod'=> date('c'),			
			'loc' => rtrim(Router::url(['lang' => $language, 'controller' => $controller, 'action' => 'index'], true), '/'),								
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
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'updated';
		$data = $this->Section->find('all', [
			'fields' => $fields
		]);
		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Section']['translated']);
			$language = $this->selectLocLanguage($langs);			
			$url = [
				'loc' => Router::url(['lang' => $language, 'controller' => 'sections', 'action' => 'view', $v['Section']['strid_' . $language]], true),			
				'lastmod'=> date('c'),				
				'lastmod'=> $v['Section']['updated'],				
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
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'updated';
		$data = $this->Category->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Category']['translated']);
			$language = $this->selectLocLanguage($langs);
			
			$url = [
				'loc' => Router::url(['lang' => $language, 'controller' => 'categories', 'action' => 'view', $v['Category']['strid_'.$language]], true),				
				'lastmod'=> date('c'),				
				'lastmod'=> $v['Category']['updated'],				
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
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'updated';
		$data = $this->Industry->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Industry']['translated']);
			$language = $this->selectLocLanguage($langs);			
			$url = [
				'loc' => Router::url(['lang' => $language, 'controller' => 'industries', 'action' => 'view', $v['Industry']['strid_' . $language]], true),			
				'lastmod'=> date('c'),				
				'lastmod'=> $v['Industry']['updated'],				
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
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'updated';
		$data = $this->Product->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields,
		]);
		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Product']['translated']);
			$language = $this->selectLocLanguage($langs);			
			$url = [
				'loc' => Router::url(['lang' => $language, 'controller' => 'products', 'action' => 'view', $v['Product']['strid_' . $language]], true),				
				'lastmod'=> date('c'),				
				'lastmod'=> $v['Product']['updated'],				
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
	private function articlesUrls(): array {
		$urls = [];
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'updated';
		$data = $this->Article->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Article']['translated']);
			$language = $this->selectLocLanguage($langs);			
			$url = [
				'loc' => Router::url(['lang' => $language, 'controller' => 'articles', 'action' => 'view', $v['Article']['strid_' . $language]], true),				
				'lastmod'=> date('c'),				
				'lastmod'=> $v['Article']['updated'],				
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
		$fields = array_map(static fn($lang) => 'strid_'.$lang, $this->langs);
		$fields[] = 'translated';
		$fields[] = 'updated';
		$data = $this->Portfolio->find('all', [
			'conditions' => ['enabled' => 1],
			'fields' => $fields
		]);
		foreach ($data as $v) {
			$langs = array_intersect($this->langs, $v['Portfolio']['translated']);
			$language = $this->selectLocLanguage($langs);			
			$url = [
				'loc' => Router::url(['lang' => $language, 'controller' => 'portfolio', 'action' => 'view', $v['Portfolio']['strid_' . $language]], true),				
				'lastmod'=> date('c'),				
				'lastmod'=> $v['Portfolio']['updated'],				
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
	
	public function selectLocLanguage($translated_langs) {
		foreach ($this->langs as $language) {
			if (in_array($language, $translated_langs)) {				
			if (in_array($language, $translated_langs, true)) {				
				return $language;
			}
		}
	}
}
}
