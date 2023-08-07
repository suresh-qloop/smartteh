<?php
class AddRequestHashColumnToContactsTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Add_request_hash_column_to_contacts_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'contacts' => array(
					'request_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4', 'after' => 'text'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'contacts' => array('request_hash'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
