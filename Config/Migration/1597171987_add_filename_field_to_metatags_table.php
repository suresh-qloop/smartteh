<?php
class AddFilenameFieldToMetatagsTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_filename_field_to_metatags_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
            'create_field' => array(
                'metatags' => array(
                    'filename' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
                ),
            ),
		),
		'down' => array(
            'drop_field' => array(
                'metatags' => array('filename'),
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
