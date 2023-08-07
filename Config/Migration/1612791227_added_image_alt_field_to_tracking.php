<?php
class AddedImageAltFieldToTracking extends CakeMigration
{

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_image_alt_field_to_tracking';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'tracking' => array(
					'img_alt' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'tracking' => array('img_alt'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param  string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param  string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
