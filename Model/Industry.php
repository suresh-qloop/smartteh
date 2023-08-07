<?php

class Industry extends AppModel
{
	public $name = 'Industry';

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
				'filename_menu' => [
					'output' => 'uploads/images/industries/menu',
					'chmod' => 0777,
					'height' => 300,
					'width' => 245,
					'mode' => 'crop'
				],
				'filename_header' => [
					'output' => 'uploads/images/industries/header',
					'move' => true
				],
				'filename_brick' => [
					'output' => 'uploads/images/industries/brick',
					'chmod' => 0777,
					'height' => 330,
					'width' => 490,
					'mode' => 'crop'
				]
			]
		]
	];

	public $hasMany = [
		'Product',
		'Portfolio',
		'Article',
	];

	public static $IMAGE_SIZE = [
		'filename_menu' => ['w' => 245, 'h' => 300],
		'filename_brick' => ['w' => 490, 'h' => 330]
	];

	public static function getAdminTabs(int $id): array {
		return [[
			'title' => __d('admin', 'Edit'),
			'url' => ['controller' => 'industries', 'action' => 'update', $id],
			'icon' => 'pencil'
		], [
			'title' => __d('admin', 'Metatags'),
			'url' => ['controller' => 'industries', 'action' => 'metatags', $id],
			'icon' => 'tags'
		], [
			'title' => __d('admin', 'View'),
			'url' => ['admin' => false, 'controller' => 'industries', 'action' => 'view', $id],
			'icon' => 'external-link',
			'ajax' => false
		]];
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

		$this->validate = [];

		foreach (Configure::read('Languages.all') as $k => $v) {
			$this->validate['title_'.$k] = [
				'rule' => ['minLength', '1'],
				'message' => __d('admin', 'This field can not be empty')
			];
		}

		return parent::beforeValidate($options);
	}

	/**
	 * Find first industry
	 *
	 * @return array|int|null
	 */
	public function getFirst() {
		return $this->find('first', [
			'conditions' => ['enabled' => 1],
			'order' => ['weight' => 'asc']
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
		$conditions = ['Industry.strid_'.$lang => $strid];

		if (!CakeSession::check('Admin')) {
			$conditions['Industry.enabled'] = 1;
			$conditions[] = 'JSON_CONTAINS(`translated`, \'"'.$lang.'"\', "$")';
		}

		return $this->find('first', [
			'conditions' => $conditions,
		]);
	}

	/**
	 * @param array $industry
	 *
	 * @return string|null
	 */
	public function getHeaderImage(array $industry): ?string {
		if (!$industry['Industry']['filename_header']) {
			return null;
		}

		return Router::url('/img/industries/header/'.$industry['Industry']['filename_header']);
	}

	/**
	 * Get all active antries
	 *
	 * @return array|int|null
	 */
	public function findAllActive() {
		return $this->find('all', [
			'conditions' => ['enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$this->lang.'"\', "$")'],
			'order' => ['weight' => 'asc']
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
			'order' => ['weight' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * Get path to current industry.
	 *
	 * Industries have only one level, so this is trivial function.
	 *
	 * @param int $id Industry ID
	 * @param string $lang
	 *
	 * @return array
	 */
	public function getFullBreadcrumbs(int $id, string $lang): array {
		$data = $this->find('first', [
			'conditions' => ['id' => $id, 'enabled' => 1]
		]);

		if (!$data) {
			return [];
		}

		return [[
			'title' => __('Industrijas'),
			'url' => ['controller' => 'industries', 'action' => 'index']
		], [
			'title' => $data['Industry']['title_'.$lang],
			'url' => ['controller' => 'industries', 'action' => 'view', $data['Industry']['strid_'.$lang]]
		]];
	}

	/**
	 * @param string $strid
	 * @param string|null $lang
	 *
	 * @return array|int|null
	 */
	public function getTrackingData(string $strid, string $lang = null) {
		$conditions = [];
		$conditions['Industry.strid_'.$lang] = $strid;

		return $this->find('first', [
			'fields' => ['id'],
			'conditions' => $conditions,
		]);
	}
}
