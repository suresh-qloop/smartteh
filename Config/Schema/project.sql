-- MariaDB dump 10.19  Distrib 10.5.9-MariaDB, for osx10.16 (x86_64)
--
-- Host: localhost    Database: smartteh
-- ------------------------------------------------------
-- Server version	10.5.9-MariaDB


--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `root` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `industry_id` int(10) unsigned DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `date` date DEFAULT NULL,
  `related_article1_id` int(10) unsigned DEFAULT NULL,
  `related_article2_id` int(10) unsigned DEFAULT NULL,
  `related_article3_id` int(10) unsigned DEFAULT NULL,
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_lv` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `strid_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `strid_ru` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `strid_es` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `strid_de` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `intro_lv` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `intro_en` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `intro_ru` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `intro_es` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `intro_de` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `text_lv` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `text_en` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `text_ru` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `text_es` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `text_de` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `alt_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `translated` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `theme_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `industry_id` (`industry_id`),
  KEY `related_article1_id` (`related_article1_id`),
  KEY `related_article2_id` (`related_article2_id`),
  KEY `related_article3_id` (`related_article3_id`),
  KEY `theme_id` (`theme_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`) ON DELETE SET NULL,
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`related_article1_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL,
  CONSTRAINT `articles_ibfk_3` FOREIGN KEY (`related_article2_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL,
  CONSTRAINT `articles_ibfk_4` FOREIGN KEY (`related_article3_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `callbacks`
--

DROP TABLE IF EXISTS `callbacks`;
CREATE TABLE `callbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `company` varchar(50) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8 NOT NULL,
  `question` text CHARACTER SET utf8 NOT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `request_hash` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `get_news` tinyint(1) NOT NULL DEFAULT 0,
  `finished` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `strid_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'KATEGORIJAS',
  `category_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'CATEGORIES',
  `category_title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'КАТЕГОРИИ',
  `category_title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'CATEGORÍAS',
  `category_title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'KATEGORIEN',
  `products_title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'IEKĀRTAS',
  `products_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'OБОРУДОВАНИЕ',
  `products_title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EQUIPMENT',
  `products_title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EQUIPO',
  `products_title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'AUSRÜSTUNG',
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filename_menu` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filename_header` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `translated` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `big_thumbnails` tinyint(1) NOT NULL DEFAULT 0,
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `strid` (`strid_lv`),
  KEY `parent_id` (`parent_id`),
  KEY `weight` (`weight`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
CREATE TABLE `certificates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `translated` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weight` (`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `text` text CHARACTER SET utf8 NOT NULL,
  `request_hash` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `get_news` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `industries`
--

DROP TABLE IF EXISTS `industries`;
CREATE TABLE `industries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `strid_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `intro_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'KATEGORIJAS',
  `category_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'CATEGORIES',
  `category_title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'КАТЕГОРИИ',
  `category_title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'CATEGORÍAS',
  `category_title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'KATEGORIEN',
  `products_title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'IEKĀRTAS',
  `products_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'OБОРУДОВАНИЕ',
  `products_title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EQUIPMENT',
  `products_title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EQUIPO',
  `products_title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'AUSRÜSTUNG',
  `filename_menu` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filename_header` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filename_brick` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `translated` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `big_thumbnails` tinyint(1) NOT NULL DEFAULT 0,
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `strid` (`strid_lv`),
  KEY `weight` (`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `metatags`
--

DROP TABLE IF EXISTS `metatags`;
CREATE TABLE `metatags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT NULL,
  `lang` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT 'lv',
  `comments` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `controller` varchar(50) CHARACTER SET utf8 NOT NULL,
  `action` varchar(50) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang_controller_action_pid` (`lang`,`controller`,`action`,`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT 'lv',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `strid` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `intro` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `date` date DEFAULT NULL,
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
CREATE TABLE `partners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `description_lv` text CHARACTER SET utf8 DEFAULT NULL,
  `description_en` text CHARACTER SET utf8 DEFAULT NULL,
  `description_ru` text CHARACTER SET utf8 DEFAULT NULL,
  `description_es` text CHARACTER SET utf8 DEFAULT NULL,
  `description_de` text CHARACTER SET utf8 DEFAULT NULL,
  `new_window` tinyint(1) NOT NULL DEFAULT 0,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL,
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE `portfolio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `industry_id` int(10) unsigned DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `filename_wide` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `date` date DEFAULT NULL,
  `mobile_frontpage` tinyint(1) NOT NULL DEFAULT 0,
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `strid_lv` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `strid_en` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `strid_ru` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `strid_es` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `strid_de` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `intro_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_lv` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `alt_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `alt_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `alt_es` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `alt_de` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `translated` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `industry_id` (`industry_id`),
  CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `portfolio_images`
--

DROP TABLE IF EXISTS `portfolio_images`;
CREATE TABLE `portfolio_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `title_lv` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_en` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_ru` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_es` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_de` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `alt_lv` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `alt_en` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `alt_ru` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `alt_es` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `alt_de` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `weight` int(10) unsigned NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolio_id` (`portfolio_id`),
  CONSTRAINT `portfolio_images_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolio` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `title_lv` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_en` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_ru` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_es` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_de` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `alt_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `weight` int(10) unsigned NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `industry_id` int(10) unsigned DEFAULT NULL,
  `strid_lv` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `strid_en` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `strid_ru` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `strid_es` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `strid_de` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_lv` text CHARACTER SET utf8 DEFAULT NULL,
  `description_en` text CHARACTER SET utf8 DEFAULT NULL,
  `description_ru` text CHARACTER SET utf8 DEFAULT NULL,
  `description_es` text CHARACTER SET utf8 DEFAULT NULL,
  `description_de` text CHARACTER SET utf8 DEFAULT NULL,
  `category_title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Kategorijas',
  `category_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Categories',
  `category_title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Категории',
  `category_title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Categorías',
  `category_title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Kategorien',
  `products_title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Iekārtas',
  `products_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Oборудование',
  `products_title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Equipment',
  `products_title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Equipo',
  `products_title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Ausrüstung',
  `manufacturer` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `alt_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alt_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `translated` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `show_contact_form` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `industry_id` (`industry_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE `quotes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT 'lv',
  `name` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `tagline` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `text` text CHARACTER SET utf8 NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `schema_migrations`
--

DROP TABLE IF EXISTS `schema_migrations`;
CREATE TABLE `schema_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `section_headings`
--

DROP TABLE IF EXISTS `section_headings`;
CREATE TABLE `section_headings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'lv',
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `strid_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `translated` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `strid_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_lv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_es` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_lv` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ru` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_es` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_de` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename_brick` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename_menu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `translated` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `weight` int(10) unsigned NOT NULL DEFAULT 1,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` varchar(50) CHARACTER SET ascii NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8 DEFAULT NULL,
  `data` text CHARACTER SET utf8 DEFAULT NULL,
  `type` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT 'varchar',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `slides`
--

DROP TABLE IF EXISTS `slides`;
CREATE TABLE `slides` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT 'lv',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `bg_filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `weight` int(10) unsigned NOT NULL,
  `new_window` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'should url (if any) be opened in new window?',
  `color` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'white, black',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `subsections`
--

DROP TABLE IF EXISTS `subsections`;
CREATE TABLE `subsections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT 'lv',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL DEFAULT '',
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_lv` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `title_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `title_es` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `title_de` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `strid_lv` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `strid_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `strid_ru` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `strid_es` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `strid_de` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `translated` varchar(255) COLLATE utf8_unicode_ci DEFAULT '[]',
  `date` date DEFAULT NULL,
  `weight` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE `tracking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'lv',
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `url_id` int(10) unsigned DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `img_count` int(11) NOT NULL DEFAULT 0,
  `img_alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `tracking_users`
--

DROP TABLE IF EXISTS `tracking_users`;
CREATE TABLE `tracking_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views_id` int(10) unsigned DEFAULT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `views_id` (`views_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `tracking_views`
--

DROP TABLE IF EXISTS `tracking_views`;
CREATE TABLE `tracking_views` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tracking_id` int(10) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `form_submit` int(11) NOT NULL DEFAULT 0,
  `pdf_download` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `tracking_id` (`tracking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Dump completed on 2021-06-28 13:29:54
