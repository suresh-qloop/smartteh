<?php

class Category extends AppModel
{
	public $name = 'Category';

	public $actsAs = [
		'L10nPlaceholder' => [
			'fields' => ['title', 'description']
		],
		'Sluggable' => [
			'overwrite' => true,
			'label' => 'title',
			'slug' => 'strid',
			'l10n' => true
		],
		'Uploader' => [
			'fields' => [
				'filename' => [
					[
						'output' => 'uploads/images/categories',
						'chmod' => 0777,
						'height' => 220,
						'width' => 220,
						'mode' => 'crop'
					],
					[
						'output' => 'uploads/images/categories/big',
						'chmod' => 0777,
						'height' => 345,
						'width' => 695,
						'mode' => 'crop'
					]
				],
				'filename_menu' => [
					'output' => 'uploads/images/categories/menu',
					'chmod' => 0777,
					'height' => 400,
					'width' => 430,
					'mode' => 'crop'
				],
				'filename_header' => [
					'output' => 'uploads/images/categories/header',
					'move' => true
				]
			]
		]
	];

	public $belongsTo = [
		'Parent' => [
			'className' => 'Category'
		]
	];

	public $hasMany = [
		'Children' => [
			'order' => ['weight' => 'asc'],
			'foreignKey' => 'parent_id',
			'className' => 'Category'
		],
		'Product'
	];

	public static $IMAGE_SIZE = [
		'filename' => ['w' => 220, 'h' => 220],
		'filename_big' => ['w' => 695, 'h' => 345],
		'filename_menu' => ['w' => 430, 'h' => 400],
	];

	public static function getAdminTabs(int $id): array {
		return [
			[
				'title' => __d('admin', 'Edit'),
				'url' => ['controller' => 'categories', 'action' => 'update', $id],
				'icon' => 'pencil'
			],
			[
				'title' => __d('admin', 'Metatags'),
				'url' => ['controller' => 'categories', 'action' => 'metatags', $id],
				'icon' => 'tags'
			],
			[
				'title' => __d('admin', 'View'),
				'url' => ['admin' => false, 'controller' => 'categories', 'action' => 'view', $id],
				'icon' => 'external-link',
				'ajax' => false
			]
		];
	}

	// do not remove or set to null
	public $validate = [];

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
			'parent_id' => [
				'rule' => ['notEqualToField', 'id'],
				'message' => __d('admin', 'Invalid parent category'),
				'on' => 'update'
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
	 * Find all threaded categories
	 *
	 * @param string $lang
	 * @param boolean $disabled If true, all entries will be returned including disabled
	 *
	 * @return array|int|null
	 */
	public function findAllThreaded(string $lang, bool $disabled = false) {
		$conditions = [];

		if (!$disabled) {
			$conditions['Category.enabled'] = 1;
			$conditions['JSON_CONTAINS(`Category`.`translated`, \'"'.$lang.'"\', "$")'] = 1;
		}

		$items = $this->find('threaded', [
			'conditions' => $conditions,
			'order' => ['Category.weight' => 'asc'],
			'contain' => [
				'Product' => [
					'fields' => ['id'],
					'conditions' => [
						'Product.enabled' => 1,
						'JSON_CONTAINS(`Product`.`translated`, \'"'.$lang.'"\', "$")' => 1
					],
				]
			]
		]);

		return array_filter($items, static fn($item) => !empty($item['Product']));
	}

	/**
	 * Find first category
	 *
	 * @return array|int|null
	 */
	public function getFirst() {
		return $this->find('first', [
			'conditions' => ['enabled' => 1, 'parent_id' => null]
		]);
	}

	/**
	 * Admin can view disabled entries
	 *
	 * @param string $strid
	 * @param string $lang
	 *
	 * @return array|int|null
	 */
	public function findByStrid(string $strid, string $lang) {
		$conditions = ['Category.strid_'.$lang => $strid];

		if (!CakeSession::check('Admin')) {
			$conditions['Category.enabled'] = 1;
			$conditions[] = 'JSON_CONTAINS(`Category`.`translated`, \'"'.$lang.'"\', "$")';
		}

		return $this->find('first', [
			'conditions' => $conditions,
			'contain' => ['Parent.filename_header']
		]);
	}

	/**
	 * Get path to current category
	 *
	 * @param int $id Category ID
	 * @param string $lang
	 *
	 * @return array
	 */
	public function getFullBreadcrumbs(int $id, string $lang): array {
		$bc = [];

		while (true) {
			$data = $this->find('first', [
				'conditions' => ['id' => $id, 'enabled' => 1]
			]);

			if (!$data) {
				return [];
			}

			$bc[] = [
				'title' => $data['Category']['title_'.$lang],
				'url' => ['controller' => 'categories', 'action' => 'view', $data['Category']['strid_'.$lang]]
			];

			if (!$data['Category']['parent_id']) {
				break;
			}

			$id = $data['Category']['parent_id'];
		}

		$bc[] = [
			'title' => __('Iekārtas'),
			'url' => ['controller' => 'categories', 'action' => 'index']
		];

		return array_reverse($bc);
	}

	/**
	 * Get path to current category
	 *
	 * @param int $id Category ID
	 *
	 * @return array
	 */
	public function getBreadcrumbs(int $id): array {
		$bc = [];

		while (true) {
			$bc[] = $id;
			$parent_id = $this->getValue($id, 'parent_id');

			if (!$parent_id) {
				break;
			}

			$id = $parent_id;
		}

		return array_reverse($bc);
	}

	/**
	 * Find category's children
	 *
	 * @param int $parent_id
	 *
	 * @return array|int|null
	 */
	public function getChildren(int $parent_id) {
		return $this->find('all', [
			'conditions' => ['parent_id' => $parent_id, 'enabled' => 1],
			'order' => 'weight'
		]);
	}

	/**
	 * Get header image
	 *
	 * @param array $category
	 *
	 * @return string|null
	 */
	public function getHeaderImage(array $category): ?string {
		if ($category['Category']['filename_header']) {
			return Router::url('/img/categories/header/'.$category['Category']['filename_header']);
		}

		if (!empty($category['Parent']['filename_header'])) {
			return Router::url('/img/categories/header/'.$category['Parent']['filename_header']);
		}

		return null;
	}


	/**
	 * Return true passed data is not equal to another field's value.
	 *
	 * If another field does not exist, return false.
	 *
	 * @param array $data
	 * @param string $fieldname
	 *
	 * @return bool
	 */
	public function notEqualToField(array $data, string $fieldname): bool {
		if (!isset($this->data[$this->name][$fieldname])) {
			return false;
		}

		return $this->data[$this->name][$fieldname] !== current($data);
	}

	/**
	 * @param string $strid
	 * @param string|null $lang
	 *
	 * @return array|int|null
	 */
	public function getTrackingData(string $strid, string $lang = null) {
		$conditions = [];
		$conditions['Category.strid_'.$lang] = $strid;

		return $this->find('first', [
			'fields' => ['id'],
			'conditions' => $conditions,
		]);
	}
}
