<?php

class Service extends AppModel
{
	public $name = 'Service';

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
				'filename_brick' => [
					'output' => 'uploads/images/services/brick',
					'chmod' => 0777,
					'height' => 230,
					'width' => 490,
					'mode' => 'crop'
				],
				'filename_menu' => [
					'output' => 'uploads/images/services/menu',
					'chmod' => 0777,
					'height' => 300,
					'width' => 326,
					'mode' => 'crop'
				],
				'filename_mobile' => [
					'output' => 'uploads/images/services/mobile',
					'chmod' => 0777,
					'height' => 100,
					'width' => 490,
					'mode' => 'crop'
				]
			]
		]
	];

	public static $IMAGE_SIZE = [
		'filename_menu' => ['w' => 326, 'h' => 300],
		'filename_brick' => ['w' => 490, 'h' => 230],
		'filename_mobile' => ['w' => 490, 'h' => 100],
	];

	public static function getAdminTabs(int $id): array {
		return [
			[
				'title' => __d('admin', 'Edit'),
				'url' => ['controller' => 'services', 'action' => 'update', $id],
				'icon' => 'pencil'
			],
			[
				'title' => __d('admin', 'Metatags'),
				'url' => ['controller' => 'services', 'action' => 'metatags', $id],
				'icon' => 'tags'
			],
			[
				'title' => __d('admin', 'View'),
				'url' => ['admin' => false, 'controller' => 'services', 'action' => 'view', $id],
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
	 * Find first service
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
		$conditions = ['Service.strid_'.$lang => $strid];

		if (!CakeSession::check('Admin')) {
			$conditions['Service.enabled'] = 1;
			$conditions[] = 'JSON_CONTAINS(`Service`.`translated`, \'"'.$lang.'"\', "$")';
		}

		return $this->find('first', [
			'conditions' => $conditions,
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
	 * Get path to current service.
	 *
	 * Service have only one level, so this is trivial function.
	 *
	 * @param int $id Service ID
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
			'title' => __('Pakalpojumi'),
			'url' => ['controller' => 'services', 'action' => 'index']
		], [
			'title' => $data['Service']['title_'.$lang],
			'url' => ['controller' => 'services', 'action' => 'view', $data['Service']['strid_'.$lang]]
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
		$conditions['Service.strid_'.$lang] = $strid;

		return $this->find('first', [
			'fields' => ['id'],
			'conditions' => $conditions,
		]);
	}
}
