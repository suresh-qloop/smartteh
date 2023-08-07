<?php

class Setting extends AppModel
{
	public $name = 'Setting';

	// do not remove or set to null
	public $validate = [];

	public $actsAs = [
		'Uploader' => [
			'fields' => [
				'value' => [
					'output' => 'uploads/settings',
					'move' => true
				]
			]
		]
	];

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
			'id' => [
				'rule' => ['uniqueField'],
				'allowEmpty' => false,
				'message' => __d('admin', 'Please fill this field with unique ID')
			],
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
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20) {
		$Controller->paginate = [
			'order' => ['Setting.title' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * Get list of all settings
	 *
	 * @return array
	 */
	public function listAll(): array {
		return $this->findList(['id', 'value']);
	}

	/**
	 * Clear value
	 *
	 * @param int $id
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function clearValue(int $id): bool {
		$data = $this->get($id);

		if ($data['Setting']['value'] === null) {
			return true;
		}

		if ($data['Setting']['type'] === 'file' && $data['Setting']['value']) {
			$filename = $data['Setting']['value'];

			Utils::deleteNode([
				APP.'webroot'.DS.'uploads'.DS.'settings'.DS.$filename
			]);
		}

		return $this->update($id, ['value' => null]);
	}
}
