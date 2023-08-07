<?php

class Certificate extends AppModel
{
	public $name = 'Certificate';

	public $actsAs = [
		'L10nPlaceholder' => [
			'fields' => ['title']
		],

		'Uploader' => [
			'fields' => [
				'filename' => [[
					'output' => 'uploads/images/certificates',
					'chmod' => 0777,
					'height' => 150,
					'width' => 120,
					'mode' => 'fit'
				], [
					'output' => 'uploads/images/certificates/original',
					'chmod' => 0777,
				]]
			]
		]
	];

	public static $IMAGE_SIZE = [
		'filename' => ['w' => 150, 'h' => 100]
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
	 * Return all active certificates
	 *
	 * @return mixed
	 */
	public function findAllActive() {
		return $this->find('all', [
			'conditions' => ['enabled' => 1, 'JSON_CONTAINS(`translated`, \'"'.$this->lang.'"\', "$")'],
			'order' => ['weight' => 'asc']
		]);
	}

	/**
	 * Get all certificates for admin panel
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
			'order' => ['Certificate.weight' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}
}
