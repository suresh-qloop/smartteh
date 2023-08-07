<?php

class Init extends CakeMigration
{

	/**
	 * Migration description
	 *
	 * @var string
	 */
	public $description = 'Init';

	/**
	 * Actions to be performed
	 *
	 * @var array $migration
	 */
	public $migration = [
		'up' => [
			'create_table' => [
				'admins' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'username' => ['type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'password' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'name' => ['type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'email' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'root' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'username' => ['column' => 'username', 'unique' => 1],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'articles' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'industry_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'date' => ['type' => 'date', 'null' => true, 'default' => null],
					'related_article1_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'related_article2_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'related_article3_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'lang' => ['column' => 'lang', 'unique' => 0],
						'enabled' => ['column' => 'enabled', 'unique' => 0],
						'industry_id' => ['column' => 'industry_id', 'unique' => 0],
						'related_article1_id' => ['column' => 'related_article1_id', 'unique' => 0],
						'related_article2_id' => ['column' => 'related_article2_id', 'unique' => 0],
						'related_article3_id' => ['column' => 'related_article3_id', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'categories' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'strid_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_en' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_es' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_de' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'description_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_lv' => ['type' => 'string', 'null' => false, 'default' => 'KATEGORIJAS', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_en' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORIES', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ru' => ['type' => 'string', 'null' => false, 'default' => 'КАТЕГОРИИ', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_es' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORÍAS', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_de' => ['type' => 'string', 'null' => false, 'default' => 'KATEGORIEN', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORII', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_lv' => ['type' => 'string', 'null' => false, 'default' => 'IEKĀRTAS', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_en' => ['type' => 'string', 'null' => false, 'default' => 'OБОРУДОВАНИЕ', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ru' => ['type' => 'string', 'null' => false, 'default' => 'EQUIPMENT', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_es' => ['type' => 'string', 'null' => false, 'default' => 'EQUIPO', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_de' => ['type' => 'string', 'null' => false, 'default' => 'AUSRÜSTUNG', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'ECHIPAMENTE', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'filename_menu' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'filename_header' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'big_thumbnails' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '1'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'strid' => ['column' => 'strid_lv', 'unique' => 0],
						'parent_id' => ['column' => 'parent_id', 'unique' => 0],
						'weight' => ['column' => 'weight', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'contacts' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'product_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'phone' => ['type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'email' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'product_id' => ['column' => 'product_id', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'industries' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'strid_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_en' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_es' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_de' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'intro_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_lv' => ['type' => 'string', 'null' => false, 'default' => 'KATEGORIJAS', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_en' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORIES', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ru' => ['type' => 'string', 'null' => false, 'default' => 'КАТЕГОРИИ', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_es' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORÍAS', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_de' => ['type' => 'string', 'null' => false, 'default' => 'KATEGORIEN', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORII', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_lv' => ['type' => 'string', 'null' => false, 'default' => 'IEKĀRTAS', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_en' => ['type' => 'string', 'null' => false, 'default' => 'OБОРУДОВАНИЕ', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ru' => ['type' => 'string', 'null' => false, 'default' => 'EQUIPMENT', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_es' => ['type' => 'string', 'null' => false, 'default' => 'EQUIPO', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_de' => ['type' => 'string', 'null' => false, 'default' => 'AUSRÜSTUNG', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'ECHIPAMENTE', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename_menu' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'filename_header' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'filename_brick' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'big_thumbnails' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '1'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'strid' => ['column' => 'strid_lv', 'unique' => 0],
						'weight' => ['column' => 'weight', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'metatags' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'pid' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'comments' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'controller' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'action' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'keywords' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'visible' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'controller' => ['column' => ['controller', 'action'], 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'offers' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'date' => ['type' => 'date', 'null' => true, 'default' => null],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'lang' => ['column' => 'lang', 'unique' => 0],
						'enabled' => ['column' => 'enabled', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'partners' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'title' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'url' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'description_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'new_window' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'filename' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'portfolio' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'industry_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename_wide' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'date' => ['type' => 'date', 'null' => true, 'default' => null],
					'mobile_frontpage' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'lang' => ['column' => 'lang', 'unique' => 0],
						'enabled' => ['column' => 'enabled', 'unique' => 0],
						'industry_id' => ['column' => 'industry_id', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'portfolio_images' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'portfolio_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'filename' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '1'],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'portfolio_id' => ['column' => 'portfolio_id', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'product_images' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'product_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'filename' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '1'],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'product_id' => ['column' => 'product_id', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'products' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'category_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'industry_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'strid_lv' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'strid_en' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'strid_ru' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'strid_es' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'strid_de' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'strid_ro' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_lv' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_en' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ru' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_es' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_de' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'title_ro' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'description_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_lv' => ['type' => 'string', 'null' => false, 'default' => 'Kategorijas', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_en' => ['type' => 'string', 'null' => false, 'default' => 'Categories', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ru' => ['type' => 'string', 'null' => false, 'default' => 'Категории', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_es' => ['type' => 'string', 'null' => false, 'default' => 'Categorías', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_de' => ['type' => 'string', 'null' => false, 'default' => 'Kategorien', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'Categorii', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_lv' => ['type' => 'string', 'null' => false, 'default' => 'Iekārtas', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_en' => ['type' => 'string', 'null' => false, 'default' => 'Oборудование', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ru' => ['type' => 'string', 'null' => false, 'default' => 'Equipment', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_es' => ['type' => 'string', 'null' => false, 'default' => 'Equipo', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_de' => ['type' => 'string', 'null' => false, 'default' => 'Ausrüstung', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'Echipamente', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'manufacturer' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'show_contact_form' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'category_id' => ['column' => 'category_id', 'unique' => 0],
						'industry_id' => ['column' => 'industry_id', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'quotes' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'name' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'tagline' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'section_headings' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'tag' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'sections' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'lang' => ['column' => 'lang', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'settings' => [
					'id' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'primary', 'collate' => 'ascii_general_ci', 'charset' => 'ascii'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'value' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'data' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'type' => ['type' => 'string', 'null' => false, 'default' => 'varchar', 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'slides' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'url' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'bg_filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'weight' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
					'new_window' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'should url (if any) be opened in new window?'],
					'color' => ['type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => 'white, black', 'charset' => 'utf8'],
					'enabled' => ['type' => 'boolean', 'null' => false, 'default' => '1'],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'site_id' => ['column' => 'lang', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
				'subsections' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'tag' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'default' => ''],
					'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
					'indexes' => [
						'PRIMARY' => ['column' => 'id', 'unique' => 1],
						'lang' => ['column' => 'lang', 'unique' => 0],
					],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'],
				],
			],
		],
		'down' => [
			'drop_table' => [
				'admins', 'articles', 'categories', 'contacts', 'industries', 'metatags', 'offers', 'partners', 'portfolio', 'portfolio_images', 'product_images', 'products', 'quotes', 'section_headings', 'sections', 'settings', 'slides', 'subsections'
			],
		],
	];

	/**
	 * Before migration callback
	 *
	 * @param string $direction Direction of migration process (up or down)
	 *
	 * @return bool Should process continue
	 */
	public function before($direction) {
		if ($direction === 'up') {
			return true;
		}

		$db = ConnectionManager::getDataSource('default');

		$db->query('ALTER TABLE `articles` DROP FOREIGN KEY `articles_ibfk_1`');
		$db->query('ALTER TABLE `articles` DROP FOREIGN KEY `articles_ibfk_2`');
		$db->query('ALTER TABLE `articles` DROP FOREIGN KEY `articles_ibfk_3`');
		$db->query('ALTER TABLE `articles` DROP FOREIGN KEY `articles_ibfk_4`');
		$db->query('ALTER TABLE `categories` DROP FOREIGN KEY `categories_ibfk_1`');
		$db->query('ALTER TABLE `contacts` DROP FOREIGN KEY `contacts_ibfk_1`');
		$db->query('ALTER TABLE `portfolio` DROP FOREIGN KEY `portfolio_ibfk_1`');
		$db->query('ALTER TABLE `portfolio_images` DROP FOREIGN KEY `portfolio_images_ibfk_1`');
		$db->query('ALTER TABLE `products` DROP FOREIGN KEY `products_ibfk_1`');
		$db->query('ALTER TABLE `products` DROP FOREIGN KEY `products_ibfk_2`');

		return true;
	}

	/**
	 * After migration callback
	 *
	 * @param string $direction Direction of migration process (up or down)
	 *
	 * @return bool Should process continue
	 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		$db = ConnectionManager::getDataSource('default');

		$db->query('ALTER TABLE `articles` ADD FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`) ON DELETE SET NULL');
		$db->query('ALTER TABLE `articles` ADD FOREIGN KEY (`related_article1_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL');
		$db->query('ALTER TABLE `articles` ADD FOREIGN KEY (`related_article2_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL');
		$db->query('ALTER TABLE `articles` ADD FOREIGN KEY (`related_article3_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL');
		$db->query('ALTER TABLE `categories` ADD FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`)');
		$db->query('ALTER TABLE `contacts` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL');
		$db->query('ALTER TABLE `portfolio` ADD FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`) ON DELETE SET NULL');
		$db->query('ALTER TABLE `portfolio_images` ADD FOREIGN KEY (`portfolio_id`) REFERENCES `portfolio` (`id`) ON DELETE CASCADE');
		$db->query('ALTER TABLE `products` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)');
		$db->query('ALTER TABLE `products` ADD FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`)');

		return true;
	}
}
