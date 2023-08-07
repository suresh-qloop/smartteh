<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * Administrators
 *
 * The are 2 types of admins - standard and root. There is only 1 root admin and he is only one
 * who can add, edit and remove other administrators (with one exception - each admin can delete
 * himself)
 */
class Admin extends AppModel
{
	public $name = 'Admin';

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
			'password1' => [
				'rule1' => [
					'rule' => ['isEqual', 'password1', 'password2'],
					'message' => __d('admin', 'Passwords do not match')
				]
			],
			'email' => [
				'rule1' => [
					'rule' => ['email'],
					'allowEmpty' => true,
					'message' => __d('admin', 'Incorrect e-mail format')
				]
			],
			'username' => [
				'rule1' => [
					'rule' => ['uniqueField'],
					'message' => __d('admin', 'This username is already taken')
				],
				'rule2' => [
					'rule' => 'alphaNumeric',
					'message' => __d('admin', 'Username can contain only letters and digits')
				]
			]
		];

		return parent::beforeValidate($options);
	}

	/**
	 * If neccessary, do the following:
	 * - hash password
	 * - set root option to false
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	public function beforeSave($options = []): bool {
		// registration/password change
		if (isset($this->data['Admin']['password1'])) {
			$BPHasher = new BlowfishPasswordHasher();
			$this->data['Admin']['password'] = $BPHasher->hash($this->data['Admin']['password1']);
		}

		// insert
		if (empty($this->id) && !empty($this->data['Admin']['root'])) {
			$this->data['Admin']['root'] = 0;
		}

		return parent::beforeSave($options);
	}

	/**
	 * Check if admin with supplied password exists
	 *
	 * @param string $userid Username or e-mail
	 * @param string $password Password
	 *
	 * @return array|false|int
	 */
	public function checkLoginCredentials(string $userid, string $password) {
		$data = $this->find('first', [
			'conditions' => ['username' => $userid]
		]);

		if (empty($data)) {
			return false;
		}

		$BPHasher = new BlowfishPasswordHasher();
		if (!$BPHasher->check($password, $data['Admin']['password'])) {
			return false;
		}

		return $data;
	}

	/**
	 * Get e-mails of all administrators (including root's)
	 *
	 * @return array
	 */
	public function listEmails(): array {
		return $this->find('list', [
			'conditions' => ['NOT' => ['email' => '']],
			'fields' => ['email']
		]);
	}

	/**
	 * Get root's e-mail
	 *
	 * @return string
	 */
	public function rootEmail(): string {
		$data = $this->find('first', [
			'conditions' => ['root' => 1]
		]);

		if ($data) {
			return $data['Admin']['email'];
		}

		return '';
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 * @param mixed $search Search fields/values
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20, $search = null) {
		$conditions = $this->searchConditions($search);

		if (!CakeSession::read('Admin.root')) {
			$conditions['id'] = CakeSession::read('Admin.id');
		}

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['Admin.created' => 'desc'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}
}
