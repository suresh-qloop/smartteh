<?php

class Portfolio extends AppModel
{
	public $name = 'Portfolio';

	public $useTable = 'portfolio';

	public $reversedWeight = true;

	public $actsAs = [
		'Sluggable' => [
			'label' => 'title',
			'slug' => 'strid'
		],
		'Uploader' => [
			'fields' => [
				'filename' => [
					'output' => 'uploads/images/portfolio',
					'chmod' => 0777,
					'height' => 330,
					'width' => 490,
					'mode' => 'crop'
				],
				'filename_wide' => [[
					'output' => 'uploads/images/portfolio/wide',
					'chmod' => 0777,
					'height' => null,
					'width' => 940,
					'mode' => 'crop'
				], [
					'output' => 'uploads/images/portfolio/wide_original',
					'mode' => 'move'
				]]
			]
		]
	];

	public $belongsTo = [
		'Industry'
	];

	public $hasMany = [
		'PortfolioImage' => [
			'order' => ['weight' => 'asc'],
			'dependent' => true
		]
	];

	public static function getAdminTabs(int $id): array {
		return [[
			'title' => __d('admin', 'Edit'),
			'url' => ['controller' => 'portfolio', 'action' => 'update', $id],
			'icon' => 'pencil'
		], [
			'title' => __d('admin', 'Images'),
			'url' => ['controller' => 'portfolio_images', 'action' => 'index', 'portfolio_id' => $id],
			'icon' => 'picture-o'
		], [
			'title' => __d('admin', 'Metatags'),
			'url' => ['controller' => 'portfolio', 'action' => 'metatags', $id],
			'icon' => 'tags'
		], [
			'title' => __d('admin', 'View'),
			'url' => ['admin' => false, 'controller' => 'portfolio', 'action' => 'view', $id],
			'icon' => 'external-link',
			'ajax' => false
		]];
	}

	public static $IMAGE_SIZE = [
		'filename' => ['w' => 490, 'h' => 330],
		'wide' => ['w' => 940, 'h' => null],
	];

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
			'title' => [
				'rule' => ['minLength', '1'],
				'message' => __d('admin', 'This field can not be empty')
			],
			'filename_file' => [
				'rule1' => [
					'rule' => ['isUploaded', true],
					'message' => __d('admin', 'Upload failed')
				],
				'rule2' => [
					'rule' => ['extension', ['', 'png', 'jpg', 'gif']],
					'message' => __d('admin', 'Only PNG, JPG and GIF files are supported')
				]
			]
		];

		return parent::beforeValidate($options);
	}

	/**
	 * Do the following:
	 * - if date is not supplied, fill in today's date
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	public function beforeSave($options = []): bool {
		if (empty($this->id) && isset($this->data['Portfolio']['date']) && $this->data['Portfolio']['date'] === '') {
			$this->data['Portfolio']['date'] = date('Y-m-d');
		}

		return parent::beforeSave($options);
	}

	/**
	 * Get latest portfolio entries
	 *
	 * @param string $lang
	 * @param mixed $limit
	 * @param bool $mobile_only
	 *
	 * @return array|int|null
	 */
	public function findLatest(string $lang, int $limit = null, bool $mobile_only = false) {
		$conditions = [
			'enabled' => 1,
			'JSON_CONTAINS(`translated`, \'"'.$lang.'"\', "$")',
			'date <' => date('Y-m-d', strtotime('tomorrow'))
		];

		if ($mobile_only) {
			$conditions['mobile_frontpage'] = 1;
		}

		return $this->find('all', [
			'conditions' => $conditions,
			'fields' => ['id', 'strid_'.$lang, 'title_'.$lang, 'intro_'.$lang, 'filename', 'alt_'.$lang],
			'order' => ['weight' => 'asc'],
			'limit' => $limit
		]);
	}

	/**
	 * Check if there is at least one active entry
	 *
	 * @return bool
	 */
	public function hasAnyActive(): bool {
		return $this->hasAny([
			'enabled' => 1, 'date <' => date('Y-m-d', strtotime('tomorrow'))
		]);
	}

	/**
	 * Administrator can see disabled articles
	 *
	 * @param string $strid
	 * @param string $lang
	 *
	 * @return array|int|null
	 */
	public function findByStrid(string $strid, string $lang) {
		$conditions = ['strid_'.$lang => $strid];

		if (!CakeSession::check('Admin')) {
			$conditions['enabled'] = 1;
			$conditions[] = 'JSON_CONTAINS(`translated`, \'"'.$lang.'"\', "$")';
		}

		return $this->find('first', [
			'conditions' => $conditions,
			'contain' => [
				'PortfolioImage' => [
					'conditions' => ['enabled' => 1]
				]
			]
		]);
	}

	/**
	 * Get all portfolio for
	 *
	 * Results will be paginated
	 *
	 * @param object $Controller
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function findAll(object $Controller, int $limit = 20) {
		$conditions = ['enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$Controller->lang.'"\', "$")'];

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['Portfolio.weight' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * Find all portfolio in industry
	 *
	 * @param string $lang
	 * @param string|array $industry_ids
	 *
	 * @return array|int|null
	 */
	public function getAllActiveInIndustry(string $lang, $industry_ids) {
		return $this->find('all', [
			'conditions' => ['industry_id' => $industry_ids, 'enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$this->lang.'"\', "$")'],
			'fields' => ['strid_'.$lang, 'title_'.$lang, 'filename_wide', 'alt_'.$lang],
			'order' => ['title_'.$lang => 'asc']
		]);
	}

	/**
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
			'order' => ['Portfolio.weight' => 'asc'],
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
			$conditions['Portfolio.enabled'] = 1;
		}

		if (!$lang) {
			$lang = $this->lang;
		}

		if (is_numeric($strid)) {
			$conditions['Portfolio.id'] = $strid;
		} else {
			$conditions['Portfolio.strid_'.$lang] = $strid;
		}

		return $this->find('first', [
			'conditions' => $conditions,
			'contain' => [
				'Industry',
				'PortfolioImage' => [
					'conditions' => ['enabled' => 1]
				]
			]
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
			'conditions' => ['enabled' => 1, 'OR' => ['title_'.$lang.' LIKE' => '%'.$keyword.'%', 'text_'.$lang.' LIKE' => '%'.$keyword.'%']],
			'order' => ['created' => 'desc'],
			'limit' => $limit
		]);
	}

	/**
	 * @param string $strid
	 * @param string|null $lang
	 *
	 * @return array|int|null
	 */
	public function getTrackingData(string $strid, string $lang = null) {
		$conditions = [];
		$conditions['Portfolio.strid_'.$lang] = $strid;

		return $this->find('first', [
			'fields' => ['id'],
			'conditions' => $conditions,
			'contain' => [
				'PortfolioImage'
			]
		]);
	}
}
