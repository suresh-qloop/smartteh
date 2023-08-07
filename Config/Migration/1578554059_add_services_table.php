<?php
class AddServicesTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Add_services_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'services' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
					'strid_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_en' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_es' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_de' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_lv' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_en' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_ru' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_es' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_de' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_ro' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_lv' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_en' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_ru' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_es' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_de' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_ro' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description_lv' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description_en' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description_ru' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description_es' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description_de' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description_ro' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'filename_brick' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'filename_menu' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'filename_mobile' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'translated' => array('type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 10, 'unsigned' => true),
					'enabled' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'services'
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
		if ($direction === 'down') {
			return true;
		}

		$db = ConnectionManager::getDataSource('default');

		$db->query('INSERT INTO `section_headings` (`lang`, `title`, `text`, `tag`, `updated`, `created`) VALUES ("lv", "Pakalpojumi", " ", "services", NOW(), NOW())');
		$db->query('INSERT INTO `section_headings` (`lang`, `title`, `text`, `tag`, `updated`, `created`) VALUES ("en", "Pakalpojumi", " ", "services", NOW(), NOW())');
		$db->query('INSERT INTO `section_headings` (`lang`, `title`, `text`, `tag`, `updated`, `created`) VALUES ("ru", "Pakalpojumi", " ", "services", NOW(), NOW())');
		$db->query('INSERT INTO `section_headings` (`lang`, `title`, `text`, `tag`, `updated`, `created`) VALUES ("es", "Pakalpojumi", " ", "services", NOW(), NOW())');
		$db->query('INSERT INTO `section_headings` (`lang`, `title`, `text`, `tag`, `updated`, `created`) VALUES ("de", "Pakalpojumi", " ", "services", NOW(), NOW())');
		$db->query('INSERT INTO `section_headings` (`lang`, `title`, `text`, `tag`, `updated`, `created`) VALUES ("ro", "Pakalpojumi", " ", "services", NOW(), NOW())');

		return true;
	}
}
