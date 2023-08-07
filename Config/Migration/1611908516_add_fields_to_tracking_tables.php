<?php
class AddFieldsToTrackingTables extends CakeMigration
{

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_fields_to_tracking_tables';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'tracking' => array(
					'url_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
					'controller' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'model' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'meta_title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'meta_description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'img_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
				),
				'tracking_views' => array(
					'form_submit' => array('type' => 'integer', 'null' => false, 'default' => 0),
					'pdf_download' => array('type' => 'integer', 'null' => false, 'default' => 0),
				),
			),

		),
		'down' => array(
			'drop_field' => array(
				'tracking' => array('url_id','controller','model', 'strid','meta_title', 'meta_description', 'img_count'),
				'tracking_views' => array('form_submit', 'pdf_download'),
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
