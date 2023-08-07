<?php
class ChangedPortfolioTableStructure extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Changed_portfolio_table_structure';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'portfolio' => array(
					'title_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'title_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'strid_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_lv' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_ru' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_es' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_de' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'intro_ro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'text_lv' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'text_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'text_ru' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'text_es' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'text_de' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'text_ro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'alt_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'translated' => array('type' => 'string', 'null' => false, 'default' => '[]', 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'tableParameters' => array('engine' => 'MyISAM'),
				),
			),
            'drop_field' => array(
                'portfolio' => array('lang','title','strid','intro','text'),
            ),
		),
		'down' => array(
            'create_field' => array(
                'portfolio' => array('lang','title','strid','intro','text'),
            ),
			'drop_field' => array(
				'portfolio' => array(
					'title_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'title_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'title_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'title_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'title_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'title_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'strid_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'strid_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'strid_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'strid_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'strid_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'strid_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'intro_lv' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'intro_ru' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'intro_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'intro_es' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'intro_de' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'intro_ro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'text_lv' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'text_ru' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'text_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'text_es' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'text_de' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
					'text_ro' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_lv' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_ru' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_es' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_de' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'alt_ro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
                    'translated' => array('type' => 'string', 'null' => false, 'default' => '[]', 'length' => 255, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'),
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
