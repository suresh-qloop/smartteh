<?php
class ChangedArticlesTableStructure extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'changed_articles_table_structure';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'articles' => array(
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
                    'intro_lv' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'intro_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'intro_ru' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'intro_es' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'intro_de' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'intro_ro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'text_lv' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'text_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'text_ru' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'text_es' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'text_de' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'text_ro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'alt_en' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'alt_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'alt_es' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'alt_de' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'alt_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'translated' => array('type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                ),
			),
			'drop_field' => array(
                'articles' => array('lang', 'title', 'strid', 'intro', 'text', 'alt', 'indexes' => array('lang')),
			),
		),
		'down' => array(
			'drop_field' => array(
                'articles' => array('title_lv', 'title_en', 'title_ru', 'title_es', 'title_de', 'title_ro', 'strid_lv', 'strid_en', 'strid_ru', 'strid_es', 'strid_de', 'strid_ro', 'intro_lv', 'intro_en', 'intro_ru', 'intro_es', 'intro_de', 'intro_ro', 'text_lv', 'text_en', 'text_ru', 'text_es', 'text_de', 'text_ro', 'alt_lv', 'alt_en', 'alt_ru', 'alt_es', 'alt_de', 'alt_ro','translated'),
            ),
			'create_field' => array(
				'articles' => array(
                    'lang' => array('type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8', 'after' => 'industry_id'),
                    'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8', 'after' => 'lang'),
                    'strid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8', 'after' => 'title'),
                    'intro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8', 'after' => 'strid'),
                    'text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8', 'after' => 'intro'),
                    'alt' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'after' => 'filename'),
                    'indexes' => array(
                        'lang' => array('column' => 'lang', 'unique' => 0),
                    ),
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
