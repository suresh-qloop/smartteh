<?php
class CreateArticlesThemeTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'create_articles_theme_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
            'create_field' => array(
                'articles' => array(
                    'theme_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
                    'indexes' => array(
                        'theme_id' => array('column' => 'theme_id', 'unique' => 0),
                    ),
                ),
            ),
            'create_table' => array(
                'themes' => array(
                    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
                    'title_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'title_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'title_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'title_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'title_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'title_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'strid_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'strid_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'strid_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'strid_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'strid_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'strid_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'translated' => array('type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'date' => array('type' => 'date', 'null' => true, 'default' => null),
                    'weight' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
                    'enabled' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
                    'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1),
                        'enabled' => array('column' => 'enabled', 'unique' => 0),
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
                ),
            ),
		),
		'down' => array(
            'drop_field' => array(
                'articles' => array('theme_id', 'indexes' => array('theme_id')),
            ),
            'drop_table' => array(
                'themes'
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
