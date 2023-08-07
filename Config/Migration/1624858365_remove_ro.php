<?php

class RemoveRo extends CakeMigration
{

	/**
	 * Migration description
	 *
	 * @var string
	 */
	public $description = 'Remove_ro';

	/**
	 * Actions to be performed
	 *
	 * @var array $migration
	 */
	public $migration = [
		'up' => [
			'drop_field' => [
				'articles' => ['title_ro', 'strid_ro', 'intro_ro', 'text_ro', 'alt_ro'],
				'categories' => ['strid_ro', 'title_ro', 'description_ro', 'category_title_ro', 'products_title_ro'],
				'certificates' => ['title_ro'],
				'industries' => ['strid_ro', 'title_ro', 'intro_ro', 'description_ro', 'category_title_ro', 'products_title_ro', 'alt_ro'],
				'metatags' => ['indexes' => ['controller']],
				'partners' => ['description_ro'],
				'portfolio' => ['title_ro', 'strid_ro', 'intro_ro', 'text_ro', 'alt_ro'],
				'portfolio_images' => ['title_ro', 'alt_ro'],
				'product_images' => ['title_ro', 'alt_ro'],
				'products' => ['strid_ro', 'title_ro', 'description_ro', 'category_title_ro', 'products_title_ro', 'alt_ro'],
				'sections' => ['strid_ro', 'title_ro', 'text_ro'],
				'services' => ['strid_ro', 'title_ro', 'intro_ro', 'description_ro'],
				'themes' => ['title_ro', 'strid_ro'],
			],
			'alter_field' => [
				'articles' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_lv' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_en' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_ru' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_es' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_de' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_lv' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_en' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_ru' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_es' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_de' => ['type' => 'text', 'null' => false, 'default' => '\'\'', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'alt_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'callbacks' => [
					'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'company' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'phone' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'question' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'email' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'request_hash' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
					'tableParameters' => ['engine' => 'InnoDB'],
				],
				'certificates' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'metatags' => [
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'controller' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
				],
				'portfolio' => [
					'filename' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'filename_wide' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'title_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_lv' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_en' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_ru' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_es' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_de' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'alt_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'alt_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'alt_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'alt_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'tableParameters' => ['engine' => 'InnoDB'],
				],
				'products' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'sections' => [
					'text_lv' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_en' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_ru' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_es' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_de' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
				],
				'themes' => [
					'title_lv' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_lv' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_en' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_ru' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_es' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_de' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'translated' => ['type' => 'string', 'null' => true, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'tracking' => [
					'url_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true],
					'meta_title' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'meta_description' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'img_count' => ['type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false],
				],
				'tracking_views' => [
					'views' => ['type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false],
					'form_submit' => ['type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false],
					'pdf_download' => ['type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false],
				],
			],
			'create_field' => [
				'metatags' => [
					'indexes' => [
						'lang_controller_action_pid' => ['column' => ['lang', 'controller', 'action', 'pid'], 'unique' => 1],
					],
				],
				'portfolio' => [
					'alt' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'after' => 'text_de'],
				],
			],
		],
		'down' => [
			'create_field' => [
				'articles' => [
					'title_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_ro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_ro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'alt_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'categories' => [
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORII', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'ECHIPAMENTE', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'certificates' => [
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'industries' => [
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'category_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'CATEGORII', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'ECHIPAMENTE', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'metatags' => [
					'indexes' => [
						'controller' => ['column' => ['controller', 'action'], 'unique' => 0],
					],
				],
				'partners' => [
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
				],
				'portfolio' => [
					'title_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_ro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_ro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'portfolio_images' => [
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
				],
				'product_images' => [
					'title_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'products' => [
					'strid_ro' => ['type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'title_ro' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'category_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'Categorii', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'products_title_ro' => ['type' => 'string', 'null' => false, 'default' => 'Echipamente', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_ro' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'sections' => [
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_ro' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'services' => [
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'description_ro' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'themes' => [
					'title_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_ro' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
				],
			],
			'alter_field' => [
				'articles' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_lv' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_en' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_ru' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_es' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'intro_de' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_lv' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_en' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_ru' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_es' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'text_de' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'alt_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_en' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_es' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_de' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'callbacks' => [
					'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'company' => ['type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'phone' => ['type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'question' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'email' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'request_hash' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM'],
				],
				'certificates' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'metatags' => [
					'lang' => ['type' => 'string', 'null' => false, 'default' => 'lv', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'controller' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'portfolio' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_en' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_es' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'strid_de' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_lv' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_en' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_ru' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_es' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'intro_de' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_lv' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_en' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_ru' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_es' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_de' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'filename_wide' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_en' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_es' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'alt_de' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM'],
				],
				'products' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'],
				],
				'sections' => [
					'text_lv' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_en' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_ru' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_es' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'text_de' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'themes' => [
					'title_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_en' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_es' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'title_de' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_lv' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_en' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_ru' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_es' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'strid_de' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'translated' => ['type' => 'string', 'null' => false, 'default' => '[]', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
				],
				'tracking' => [
					'url_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'],
					'meta_title' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
					'meta_description' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_latvian_ci', 'charset' => 'utf8'],
					'img_count' => ['type' => 'integer', 'null' => false, 'default' => 0],
				],
				'tracking_views' => [
					'views' => ['type' => 'integer', 'null' => false, 'default' => 1],
					'form_submit' => ['type' => 'integer', 'null' => false, 'default' => 0],
					'pdf_download' => ['type' => 'integer', 'null' => false, 'default' => 0],
				],
			],
			'drop_field' => [
				'metatags' => ['indexes' => ['lang_controller_action_pid']],
				'portfolio' => ['alt'],
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
	public function before($direction): bool {
		if ($direction === 'down') {
			return true;
		}

		$db = ConnectionManager::getDataSource('default');

		$db->query('DELETE FROM `metatags` WHERE lang = "ro"');
		$db->query('DELETE FROM `offers` WHERE lang = "ro"');
		$db->query('DELETE FROM `quotes` WHERE lang = "ro"');
		$db->query('DELETE FROM `section_headings` WHERE lang = "ro"');
		$db->query('DELETE FROM `subsections` WHERE lang = "ro"');
		$db->query('DELETE FROM `slides` WHERE lang = "ro"');
		$db->query('DELETE FROM `tracking` WHERE lang = "ro"');

		return true;
	}

	///**
	// * After migration callback
	// *
	// * @param string $direction Direction of migration process (up or down)
	// *
	// * @return bool Should process continue
	// */
	//public function after($direction): bool {
	//	return true;
	//}
}
