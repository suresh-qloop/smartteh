<?php

class Product extends AppModel
{
	public $name = 'Product';

	public $actsAs = [
		'Sluggable' => [
			'overwrite' => true,
			'label' => 'title',
			'slug' => 'strid',
			'l10n' => true
		],
		'Uploader' => [
			'fields' => [
				'filename' => [[
					'output' => 'uploads/images/products/small',
					'paddings' => '#fff',
					'chmod' => 0777,
					'height' => 220,
					'width' => 220,
					'mode' => 'fit'
				], [
					'output' => 'uploads/images/products/medium',
					'paddings' => '#fff',
					'chmod' => 0777,
					'height' => 241,
					'width' => 241,
					'mode' => 'fit'
				], [
					'output' => 'uploads/images/products/large',
					'enlarge' => false,
					'height' => 1500,
					'width' => 1500,
					'chmod' => 0777,
					'mode' => 'fit'
				], [
					'output' => 'uploads/images/products/original',
					'move' => true
				]]
			]
		]
	];

	public $belongsTo = [
		'Category',
		'Industry'
	];

	public $hasMany = [
		'ProductImage' => [
			'order' => ['weight' => 'asc'],
			'dependent' => true
		],
		'Contact'
	];

	public static $IMAGE_SIZE = [
		'filename' => ['w' => 600, 'h' => 600]
	];

	// do not remove or set to null
	public $validate = [];

	public static function getAdminTabs(int $id): array {
		return [[
			'title' => __d('admin', 'Edit'),
			'url' => ['controller' => 'products', 'action' => 'update', $id],
			'icon' => 'pencil'
		], [
			'title' => __d('admin', 'Images'),
			'url' => ['controller' => 'product_images', 'action' => 'index', 'product_id' => $id],
			'icon' => 'picture-o'
		], [
			'title' => __d('admin', 'Metatags'),
			'url' => ['controller' => 'products', 'action' => 'metatags', $id],
			'icon' => 'tags'
		], [
			'title' => __d('admin', 'View'),
			'url' => ['admin' => false, 'controller' => 'products', 'action' => 'view', $id],
			'icon' => 'external-link',
			'ajax' => false
		]];
	}

	/**
	 * Set validation rules. Why here? So we can apply localization. If you want to skip validation,
	 * unset $this->validate variable before validation/save
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	public function beforeValidate($options = []): bool {
		if (!isset($this->validate)) {
			return true;
		}

		$this->validate = [
			'filename_file' => [
				'rule1' => [
					'rule' => ['isUploaded', 3],
					'message' => __d('admin', 'Please specify file')
				],
				'rule2' => [
					'rule' => ['extension', ['', 'png', 'jpg', 'gif', 'svg']],
					'message' => __d('admin', 'Only PNG, JPG and GIF files are supported')
				]
			],
			'share_email' => [
				'rule' => 'email',
				'allowEmpty' => false,
				'message' => __('Lūdzu, norādiet korektu e-pastu')
			]
		];

		foreach (Configure::read('Languages.all') as $k => $v) {
			$this->validate['title_'.$k] = [
				'rule' => ['minLength', '1'],
				'message' => __d('admin', 'This field can not be empty')
			];
		}

		return parent::beforeValidate($options);
	}

	/**
	 * Autofill all titles on create.
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	public function beforeSave($options = []): bool {
		if (empty($this->id)) {
			$this->fillTitlesAndSlugsOnCreate();
		}

		return parent::beforeSave($options);
	}

	/**
	 * Get all products for admin panel
	 *
	 * Results will be paginated
	 *
	 * @param object $Controller
	 * @param int $limit
	 * @param mixed $search Search fields/values
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20, $search = null) {
		$conditions = [];

		$conditions = array_merge($conditions, $this->searchConditions($search));

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['Product.created' => 'desc'],
			'contain' => [
				'Category' => ['strid_'.$Controller->lang, 'title_'.$Controller->lang],
				'Industry' => ['strid_'.$Controller->lang, 'title_'.$Controller->lang]
			],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * Find product by it's strid or id
	 *
	 * @param mixed $strid Strid or id
	 * @param string|null $lang
	 *
	 * @return array|int|null
	 */
	public function getFull($strid, string $lang = null) {
		$conditions = [];

		if (!CakeSession::check('Admin')) {
			$conditions['Product.enabled'] = 1;
			$conditions[] = 'JSON_CONTAINS(`Product`.`translated`, \'"'.$lang.'"\', "$")';
		}

		if (!$lang) {
			$lang = $this->lang;
		}

		if (is_numeric($strid)) {
			$conditions['Product.id'] = $strid;
		} else {
			$conditions['Product.strid_'.$lang] = $strid;
		}

		return $this->find('first', [
			'conditions' => $conditions,
			'contain' => [
				'Category' => [
					'Parent.filename_header'
				],
				'Industry',
				'ProductImage' => [
					'conditions' => ['enabled' => 1]
				]
			]
		]);
	}

	/**
	 * Find all products in category
	 *
	 * @param string $lang
	 * @param mixed $category_ids
	 *
	 * @return array|int|null
	 */
	public function getAllActiveInCategory(string $lang, $category_ids) {
		return $this->find('all', [
			'conditions' => [
				'JSON_CONTAINS(`Product`.`translated`, \'"'.$lang.'"\', "$")',
				'category_id' => $category_ids,
				'enabled' => 1
			],
			'fields' => ['strid_'.$lang, 'title_'.$lang, 'filename'],
			'order' => ['created' => 'asc']
		]);
	}

	/**
	 * Find all products in industry
	 *
	 * @param string $lang
	 * @param mixed $industry_ids
	 *
	 * @return array|int|null
	 */
	public function getAllActiveInIndustry(string $lang, $industry_ids) {
		return $this->find('all', [
			'conditions' => [
				'JSON_CONTAINS(`Product`.`translated`, \'"'.$lang.'"\', "$")',
				'industry_id' => $industry_ids,
				'enabled' => 1
			],
			'fields' => ['strid_'.$lang, 'title_'.$lang, 'filename', 'alt_'.$lang],
			'order' => ['title_'.$lang => 'asc']
		]);
	}

	/**
	 * Search items for autosuggest
	 *
	 * @param string $lang
	 * @param string $keyword
	 * @param mixed $limit
	 *
	 * @return array|int|null
	 */
	public function autosuggest(string $lang, string $keyword, $limit = false) {
		return $this->find('all', [
			'conditions' => [
				'JSON_CONTAINS(`Product`.`translated`, \'"'.$lang.'"\', "$")',
				'enabled' => 1,
				'title_'.$lang.' LIKE' => '%'.$keyword.'%'
			],
			'order' => ['created' => 'desc'],
			'limit' => $limit
		]);
	}

	/**
	 * Find and convert relative urls/paths in $fields
	 *
	 * @param mixed $data
	 * @param string[] $fields
	 *
	 * @return mixed
	 */
	public function relativePathsToAbsolute($data, array $fields) {
		$root = Router::url('/', true);

		foreach ($fields as $field) {
			$data[$field] = preg_replace('/src="\/(.*)"/Usi', 'src="'.$root.'${1}"', $data[$field]);
			$data[$field] = preg_replace('/href="\/(.*)"/Usi', 'href="'.$root.'${1}"', $data[$field]);
		}

		return $data;
	}

	/**
	 * Duplicate product
	 *
	 * @param int $id
	 *
	 * @return int|bool New ID
	 * @throws \Exception
	 */
	public function duplicate(int $id) {
		$data = $this->get($id, ['ProductImage']);

		unset($data['Product']['id'], $data['Product']['updated'], $data['Product']['created']);
		foreach (Configure::read('Languages.all') as $k => $v) {
			unset($data['Product']['strid_'.$k]);
		}
		$data['Product']['enabled'] = 0;

		if ($data['Product']['filename']) {
			$filename = null;
			foreach ($this->actsAs['Uploader']['fields']['filename'] as $v) {
				$dir_path = WWW_ROOT.$v['output'].DS;
				if (!$filename) {
					$filename = Utils::safeFilename($data['Product']['filename'], $dir_path);
				}
				copy($dir_path.$data['Product']['filename'], $dir_path.$filename);
			}
			$data['Product']['filename'] = $filename;
		}

		if (!$this->save($data, false)) {
			return false;
		}

		$new_id = $this->id;

		if ($data['ProductImage']) {
			$images = [];
			foreach ($data['ProductImage'] as $image) {
				$filename = null;
				foreach ($this->ProductImage->items as $item) {
					$dir_path = WWW_ROOT.'img'.DS.$item['output'].DS;
					if (!$filename) {
						$filename = Utils::safeFilename($image['filename'], $dir_path);
					}
					copy($dir_path.$image['filename'], $dir_path.$filename);
				}
				unset($image['id'], $image['updated'], $image['created']);
				$image['product_id'] = $new_id;
				$image['filename'] = $filename;
				$images[] = $image;
			}
			$this->ProductImage->saveAll($images);
		}

		return $new_id;
	}

	/**
	 * @param string $strid
	 * @param string|null $lang
	 *
	 * @return array|int|null
	 */
	public function getTrackingData(string $strid, string $lang = null) {
		$conditions = [];
		$conditions['Product.strid_'.$lang] = $strid;

		return $this->find('first', [
			'fields' => ['id'],
			'conditions' => $conditions,
			'contain' => [
				'ProductImage'
			]
		]);
	}
}
