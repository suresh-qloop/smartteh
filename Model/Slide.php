<?php

class Slide extends AppModel
{
	public $name = 'Slide';

	public $actsAs = [
		'Uploader' => [
			'fields' => [
				'filename' => [
					'output' => 'uploads/images/slides',
					'chmod' => 0777,
					'height' => 300,
					'width' => 980,
					'mode' => 'crop'
				],
				'bg_filename' => [
					'output' => 'uploads/images/slides/bg',
					'enlarge' => false,
					'chmod' => 0777,
					'height' => 1080,
					'width' => 1920,
					'mode' => 'crop'
				]
			]
		]
	];

	// do not remove or set to null
	public $validate = [];

	public static $IMAGE_SIZE = [
		'filename' => ['w' => 980, 'h' => 300],
		'bg_filename' => ['w' => 1920, 'h' => 1080]
	];

	// Hard coded colors for slider

	public $colors = [
		'black' => 'black',
		'white' => 'white',
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
	 * Get active slides
	 *
	 * @param string $lang
	 *
	 * @return array|int|null
	 */
	public function findActive(string $lang) {
		return $this->find('all', [
			'conditions' => ['lang' => $lang, 'enabled' => 1],
			'order' => ['weight' => 'asc']
		]);
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20) {
		$Controller->paginate = [
			'conditions' => ['lang' => $Controller->lang],
			'order' => ['Slide.weight' => 'asc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}
}
