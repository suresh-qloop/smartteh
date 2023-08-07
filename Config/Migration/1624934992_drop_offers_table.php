<?php
class DropOffersTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Drop_offers_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_table' => array(
				'offers'
			),
		),
		'down' => array(
			'create_table' => array(
				'offers' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
					'lang' => array('type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'strid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'intro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'filename' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'date' => array('type' => 'date', 'null' => true, 'default' => null),
					'weight' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
					'enabled' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
					'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'lang' => array('column' => 'lang', 'unique' => 0),
						'enabled' => array('column' => 'enabled', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
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
