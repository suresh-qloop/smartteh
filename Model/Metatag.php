<?php

class Metatag extends AppModel
{
	/**
	 * @var string
	 */
	public $name = 'Metatag';

	/**
	 * @var array
	 */
	public $actsAs = [
		'Uploader' => [
			'fields' => [
				'filename' => [[
					'output' => 'uploads/images/metatags',
					'chmod' => 0777,
					'height' => 627,
					'width' => 1200,
					'mode' => 'crop'
				]]
			]
		]
	];

	/**
	 * @var array
	 */
	public static $IMAGE_SIZE = [
		'filename' => ['w' => 1200, 'h' => 627],
	];

	/**
	 * @param string $lang
	 * @param string $controller
	 * @param string $action
	 * @param int|null $pid
	 *
	 * @return bool
	 */
	public function remove(string $lang, string $controller, string $action, int $pid = null): bool {
		$conditions = ['controller' => $controller, 'action' => $action];

		if (!empty($lang)) {
			$conditions['lang'] = $lang;
		}

		if ($pid !== null) {
			$conditions['pid'] = $pid;
		}

		$data = $this->find('first', [
			'conditions' => $conditions
		]);

		if ($data) {
			return $this->delete($data['Metatag']['id']);
		}

		return false;
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 * @param mixed $search
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20, $search = null) {
		$conditions = ['lang' => $Controller->lang, 'visible' => 1];

		$conditions = array_merge($conditions, $this->searchConditions($search));

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['Metatag.controller' => 'asc', 'Metatag.action' => 'asc', 'Metatag.pid' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * @param array $save_data
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function saveData(array $save_data): bool {
		$conditions = ['controller' => $save_data['controller'], 'action' => $save_data['action']];

		if (!empty($save_data['lang'])) {
			$conditions['lang'] = $save_data['lang'];
		}

		if ($save_data['pid'] !== null) {
			$conditions['pid'] = $save_data['pid'];
		}

		$data = $this->find('first', [
			'conditions' => $conditions
		]);

		$save_data['id'] = $data ? $data['Metatag']['id'] : null;

		return (bool)$this->save($save_data);
	}

	/**
	 * Get full metatag data
	 *
	 * @param array $data
	 * @param boolean $meta_fields_only If true, return only title, description and keywords fields
	 *
	 * @return array|int|null
	 */
	public function getData(array $data, bool $meta_fields_only = false) {
		$conditions = ['controller' => $data['controller'], 'action' => $data['action']];

		if (!empty($data['lang'])) {
			$conditions['lang'] = $data['lang'];
		}

		if ($data['pid'] !== null) {
			$conditions['pid'] = $data['pid'];
		}

		$fields = null;

		if ($meta_fields_only) {
			$fields = ['title', 'description', 'keywords', 'filename'];
		}

		return $this->find('first', [
			'conditions' => $conditions,
			'fields' => $fields
		]);
	}
}
