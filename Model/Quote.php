<?php

class Quote extends AppModel
{
	public $name = 'Quote';

	public $actsAs = [
		'Uploader' => [
			'fields' => [
				'filename' => [
					'output' => 'uploads/images/quotes',
					'chmod' => 0777,
					'height' => 90,
					'width' => 90,
					'mode' => 'crop'
				]
			]
		]
	];

	public static $IMAGE_SIZE = [
		'filename' => ['w' => 90, 'h' => 90]
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
			'name' => [
				'rule' => ['minLength', 1],
				'message' => __d('admin', 'This field can not be empty')
			],
			'text' => [
				'rule' => ['minLength', 1],
				'message' => __d('admin', 'This field can not be empty')
			],
			'filename_file' => [
				'rule1' => [
					'rule' => ['isUploaded', 3],
					'message' => __d('admin', 'Please specify file')
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
	 * Get random active quotes
	 *
	 * @param string $lang
	 *
	 * @return array|int|null
	 */
	public function getRandomQuotes(string $lang) {
		return $this->find('all', [
			'conditions' => ['lang' => $lang, 'enabled' => 1],
			'order' => 'RAND()'
		]);
	}

	/**
	 * Get all quotes for admin panel
	 *
	 * Results will be paginated
	 *
	 * @param object $Controller
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20) {
		$Controller->paginate = [
			'conditions' => ['lang' => $Controller->lang],
			'order' => ['Quote.name' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}
}
