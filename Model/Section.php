<?php

class Section extends AppModel
{
	public $name = 'Section';

	public $actsAs = [
		'Sluggable' => [
			'label' => 'title_lv',
			'slug' => 'strid_lv'
		]
	];

	public static function getAdminTabs(int $id): array
	{
		return [
			[
				'title' => __d('admin', 'Edit'),
				'url' => ['controller' => 'sections', 'action' => 'update', $id],
				'icon' => 'pencil'
			],
			[
				'title' => __d('admin', 'Metatags'),
				'url' => ['controller' => 'sections', 'action' => 'metatags', $id],
				'icon' => 'tags'
			],
			[
				'title' => __d('admin', 'View'),
				'url' => ['admin' => false, 'controller' => 'sections', 'action' => 'view', $id],
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
	public function beforeValidate($options = []): bool
	{
		if (!isset($this->validate)) {
			return true;
		}

		$this->validate = [
			'title' => [
				'rule' => ['minLength', '1'],
				'message' => __d('admin', 'This field can not be empty')
			]
		];

		return parent::beforeValidate($options);
	}

	/**
	 * Autofill all titles on create.
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	public function beforeSave($options = []): bool
	{

		if (empty($this->id)) {
			$this->fillTitlesAndSlugsOnCreate();
		}

		return parent::beforeSave($options);
	}

	/**
	 * @param string $strid
	 * @param string $lang
	 *
	 * @return array|int|null
	 */
	public function findByStrid(string $strid, string $lang)
	{
		return $this->find('first', [
			'conditions' => ['strid_' . $lang => $strid, 'JSON_CONTAINS(`translated`, \'"' . $lang . '"\', "$")']
		]);
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20)
	{
		$Controller->paginate = [
			'conditions' => [],
			'order' => ['title' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * Find product by it's strid or id
	 *
	 * @param mixed $strid Strid or id
	 * @param string|null $lang Language
	 *
	 * @return array|int|null
	 */
	public function getFull($strid, string $lang = null)
	{
		$conditions = [];

		if (!$lang) {
			$lang = $this->lang;
		}

		if (is_numeric($strid)) {
			$conditions['Section.id'] = $strid;
		} else {
			$conditions['Section.strid_' . $lang] = $strid;
		}

		return $this->find('first', [
			'conditions' => $conditions,
		]);
	}

	/**
	 * @param string $strid
	 * @param string|null $lang
	 *
	 * @return array|int|null
	 */
	public function getTrackingData(string $strid, string $lang = null)
	{
		$conditions = [];
		$conditions['Section.strid_' . $lang] = $strid;

		return $this->find('first', [
			'fields' => ['id'],
			'conditions' => $conditions,
		]);
	}
}
