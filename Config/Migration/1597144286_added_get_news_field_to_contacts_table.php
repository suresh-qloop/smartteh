<?php
class AddedGetNewsFieldToContactsTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_get_news_field_to_contacts_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
            'create_field' => array(
                'contacts' => array(
                    'get_news' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
                ),
            ),

		),
		'down' => array(
            'drop_field' => array(
                'contacts' => array('get_news'),
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
