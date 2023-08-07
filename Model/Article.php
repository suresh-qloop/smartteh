<?php

class Article extends AppModel
{
	public $name = 'Article';

	public $useTable = 'articles';

	public $actsAs = [
		'Sluggable' => [
			'label' => 'title',
			'slug' => 'strid'
		],
		'Uploader' => [
			'fields' => [
				'filename' => [
					[
						'output' => 'uploads/images/articles/thumb',
						'chmod' => 0777,
						'height' => 370,
						'width' => 490,
						'mode' => 'crop'
					],
					[
						'output' => 'uploads/images/articles/original',
						'mode' => 'move'
					]
				]
			]
		]
	];

	public $belongsTo = [
		'Industry'
	];

	public static function getAdminTabs($id): array {
		return [
			[
				'title' => __d('admin', 'Edit'),
				'url' => ['controller' => 'articles', 'action' => 'update', $id],
				'icon' => 'pencil'
			],
			[
				'title' => __d('admin', 'Metatags'),
				'url' => ['controller' => 'articles', 'action' => 'metatags', $id],
				'icon' => 'tags'
			],
			[
				'title' => __d('admin', 'View'),
				'url' => ['admin' => false, 'controller' => 'articles', 'action' => 'view', $id],
				'icon' => 'external-link',
				'ajax' => false
			]
		];
	}

	public static $IMAGE_SIZE = [
		'filename' => ['w' => 490, 'h' => 370]
	];

	public static $IMAGE_SIZE_SMALL = [
		'filename' => ['w' => 220, 'h' => 220]
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
		// create
		if (empty($this->id)) {
			if (isset($this->data['Article']['date']) && !$this->data['Article']['date']) {
				$this->data['Article']['date'] = date('Y-m-d');
			}

			$this->fillTitlesAndSlugsOnCreate();
		}

		return parent::beforeSave($options);
	}

	/**
	 * Get latest articles entries
	 *
	 * @param string $lang
	 * @param int|null $limit How many entries to return
	 *
	 * @return array|int|null
	 */
	public function findLatest(string $lang, int $limit = null) {
		return $this->find('all', [
			'conditions' => [
				'enabled' => 1,
				'JSON_CONTAINS(`translated`, \'"'.$lang.'"\', "$")',
				'date <' => date('Y-m-d', strtotime('tomorrow'))
			],
			'fields' => ['id', 'strid_'.$lang, 'title_'.$lang, 'intro_'.$lang, 'filename', 'alt_'.$lang],
			'order' => ['created' => 'desc'],
			'limit' => $limit
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

		$data = $this->find('first', [
			'conditions' => $conditions
		]);

		if (!$data) {
			return $data;
		}

		$related_ids = [];
		for ($i = 1; $i < 4; $i++) {
			if ($data['Article']['related_article'.$i.'_id']) {
				$related_ids[] = $data['Article']['related_article'.$i.'_id'];
			}
		}
		$related_ids = array_unique($related_ids);

		$related_articles = [];
		if ($related_ids) {
			$related_articles = $this->find('all', [
				'conditions' => ['id' => $related_ids, 'enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$lang.'"\', "$")']
			]);
			$related_articles = Hash::extract($related_articles, '{n}.Article');
		}

		$data['RelatedArticle'] = $related_articles;

		return $data;
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 * @param array $conditions
	 *
	 * @return mixed
	 */
	public function findAll(object $Controller, int $limit = 20, array $conditions = []) {
		$conditions = array_merge($conditions, [
			'enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$Controller->lang.'"\', "$")',
		]);

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['created' => 'desc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * @return array|int|null
	 */
	public function findAllActive() {
		return $this->find('all', [
			'conditions' => ['enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$this->lang.'"\', "$")'],
			'order' => ['created' => 'asc']
		]);
	}

	/**
	 * Find all portfolio in industry
	 *
	 * @param string $lang
	 * @param int|array $industry_ids
	 *
	 * @return array|int|null
	 */
	public function getAllActiveInIndustry(string $lang, $industry_ids) {
		return $this->find('all', [
			'conditions' => ['industry_id' => $industry_ids, 'enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$lang.'"\', "$")'],
			'fields' => ['strid_'.$lang, 'title_'.$lang, 'filename', 'alt_'.$lang, 'intro_'.$lang],
			'order' => ['created' => 'asc']
		]);
	}

	/**
	 * Get all entries for admin panel
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
			'order' => ['created' => 'asc'],
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
			$conditions['Article.enabled'] = 1;
		}

		if (!$lang) {
			$lang = $this->lang;
		}

		if (is_numeric($strid)) {
			$conditions['Article.id'] = $strid;
		} else {
			$conditions['Article.strid_'.$lang] = $strid;
		}

		return $this->find('first', [
			'conditions' => $conditions,
			'contain' => [
				'Industry',
			]
		]);
	}

	/**
	 * Get path to current article
	 *
	 * @param int $id Article ID
	 * @param string $lang
	 *
	 * @return array
	 */
	public function getFullBreadcrumbs(int $id, string $lang): array {
		$bc = [];

		$data = $this->find('first', [
			'conditions' => ['id' => $id, 'enabled' => 1]
		]);

		if (!$data) {
			return [];
		}

		$bc[] = [
			'title' => $data['Article']['title_'.$lang],
			'url' => ['controller' => 'articles', 'action' => 'view', $data['Article']['strid_'.$lang]]
		];


		$bc[] = [
			'title' => __('Articles'),
			'url' => ['controller' => 'articles', 'action' => 'index']
		];

		return array_reverse($bc);
	}

	/**
	 * @param string $strid
	 * @param string|null $lang
	 *
	 * @return array|int|null
	 */
	public function getTrackingData(string $strid, string $lang = null) {
		$conditions = [];
		$conditions['Article.strid_'.$lang] = $strid;

		return $this->find('first', [
			'fields' => ['id'],
			'conditions' => $conditions,
		]);
	}
}
