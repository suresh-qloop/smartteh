<?php

class Theme extends AppModel
{
	public $name = 'Theme';

	public $useTable = 'themes';

	public $actsAs = [
		'Sluggable' => [
			'label' => 'title',
			'slug' => 'strid'
		],
	];

	public static function getAdminTabs(int $id): array {
		return [
			[
				'title' => __d('admin', 'Edit'),
				'url' => ['controller' => 'themes', 'action' => 'update', $id],
				'icon' => 'pencil'
			],
			[
				'title' => __d('admin', 'View'),
				'url' => ['admin' => false, 'controller' => 'themes', 'action' => 'view', $id],
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
			'title' => [
				'rule' => ['minLength', '1'],
				'message' => __d('admin', 'This field can not be empty')
			],
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
		if (empty($this->id) && isset($this->data['Theme']['date']) && $this->data['Theme']['date'] === '') {
			$this->data['Theme']['date'] = date('Y-m-d');
		}

		return parent::beforeSave($options);
	}

	/**
	 * Get latest themes entries
	 *
	 * @param string $lang
	 * @param mixed $limit How many entries to return
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
			'fields' => ['id', 'strid_'.$lang, 'title_'.$lang],
			'order' => ['weight' => 'desc'],
			'limit' => $limit
		]);
	}

	/**
	 * Administrator can see disabled themes
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
			'conditions' => $conditions
		]);
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function findAll(object $Controller, int $limit = 20) {
		$conditions = ['enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$Controller->lang.'"\', "$")'];

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['weight' => 'desc'],
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
			'order' => ['weight' => 'asc']
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
			'order' => ['weight' => 'asc'],
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
			$conditions['Theme.enabled'] = 1;
		}

		if (!$lang) {
			$lang = $this->lang;
		}

		if (is_numeric($strid)) {
			$conditions['Theme.id'] = $strid;
		} else {
			$conditions['Theme.strid_'.$lang] = $strid;
		}

		return $this->find('first', [
			'conditions' => $conditions,
		]);
	}
}
