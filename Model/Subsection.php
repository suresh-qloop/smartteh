<?php

class Subsection extends AppModel
{
	public $name = 'Subsection';

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
			]
		];

		return parent::beforeValidate($options);
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 * @param mixed $search Search fields/values
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20, $search = null) {
		$conditions = ['lang' => $Controller->lang];

		$conditions = array_merge($conditions, $this->searchConditions($search));

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['Subsection.weight' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * Find subsection by lang and tag
	 *
	 * @param string $lang
	 * @param string $tag
	 *
	 * @return array|int|null
	 */
	public function findByTag(string $lang, string $tag) {
		return $this->find('first', [
			'conditions' => ['lang' => $lang, 'tag' => $tag]
		]);
	}
}
