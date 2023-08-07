<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @package   app.Config
 * @since     CakePHP(tm) v 0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

$lang = Configure::read('Languages.default');
$langs = implode('|', array_keys(Configure::read('Languages.all')));

Router::connect(
	'/',
	['controller' => 'start', 'action' => 'index', 'lang' => 'lv']
);

Router::connect(
	'/:lang',
	['controller' => 'start', 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/admin/:lang/:controller',
	['lang' => $lang, 'admin' => true, 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/admin/:lang/:controller/:action/*',
	['lang' => $lang, 'admin' => true],
	['lang' => $langs]
);

// ===========================================================================

Router::connect(
	'/info/*',
	['controller' => 'sections', 'action' => 'view', 'lang' => 'lv']
);

Router::connect(
	'/:lang/info/*',
	['controller' => 'sections', 'action' => 'view'],
	['lang' => $langs]
);

Router::connect(
	'/portfolio',
	['controller' => 'portfolio', 'action' => 'index', 'lang' => 'lv']
);

Router::connect(
	'/portfolio/index/*',
	['controller' => 'portfolio', 'action' => 'index', 'lang' => 'lv']
);

Router::connect(
	'/portfolio/*',
	['controller' => 'portfolio', 'action' => 'view', 'lang' => 'lv']
);

Router::connect(
	'/:lang/portfolio',
	['controller' => 'portfolio', 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/:lang/portfolio/index/*',
	['controller' => 'portfolio', 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/:lang/portfolio/*',
	['controller' => 'portfolio', 'action' => 'view'],
	['lang' => $langs]
);

Router::connect(
	'/iekartas',
	['controller' => 'categories', 'action' => 'index', 'lang' => 'lv']
);

Router::connect(
	'/iekartas/*',
	['controller' => 'categories', 'action' => 'view', 'lang' => 'lv']
);

Router::connect(
	'/:lang/categories',
	['controller' => 'categories', 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/:lang/categories/*',
	['controller' => 'categories', 'action' => 'view'],
	['lang' => $langs]
);

Router::connect(
	'/iekarta/pdf/*',
	['controller' => 'products', 'action' => 'pdf', 'lang' => 'lv']
);

Router::connect(
	'/iekarta/dalities',
	['controller' => 'products', 'action' => 'share_via_email', 'lang' => 'lv']
);

Router::connect(
	'/iekarta/*',
	['controller' => 'products', 'action' => 'view', 'lang' => 'lv']
);

Router::connect(
	'/:lang/product/*',
	['controller' => 'products', 'action' => 'view'],
	['lang' => $langs]
);

Router::connect(
	'/industrijas',
	['controller' => 'industries', 'action' => 'index', 'lang' => 'lv']
);

Router::connect(
	'/industrijas/*',
	['controller' => 'industries', 'action' => 'view', 'lang' => 'lv']
);

Router::connect(
	'/:lang/industries',
	['controller' => 'industries', 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/:lang/industries/*',
	['controller' => 'industries', 'action' => 'view'],
	['lang' => $langs]
);

Router::connect(
	'/pakalpojumi',
	['controller' => 'services', 'action' => 'index', 'lang' => 'lv']
);

Router::connect(
	'/pakalpojumi/*',
	['controller' => 'services', 'action' => 'view', 'lang' => 'lv']
);

Router::connect(
	'/:lang/services',
	['controller' => 'services', 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/:lang/services/*',
	['controller' => 'services', 'action' => 'view'],
	['lang' => $langs]
);

Router::connect(
	'/kontakti',
	['controller' => 'contacts', 'action' => 'index', 'lang' => 'lv']
);

Router::connect(
	'/blogs',
	['controller' => 'articles', 'action' => 'index', 'lang' => 'lv']
);
Router::connect(
	'/blogs/*',
	['controller' => 'articles', 'action' => 'index', 'lang' => 'lv']
);
Router::connect(
	'/article/*',
	['controller' => 'articles', 'action' => 'view', 'lang' => 'lv']
);

Router::connect(
	'/:lang/blog',
	['controller' => 'articles', 'action' => 'index'],
	['lang' => $langs]
);
Router::connect(
	'/:lang/blogs/*',
	['controller' => 'articles', 'action' => 'view'],
	['lang' => $langs]
);
Router::connect(
	'/:lang/article/*',
	['controller' => 'articles', 'action' => 'view'],
	['lang' => $langs]
);

Router::connect(
	'/:lang/tracking/saveclick',
	['controller' => 'tracking', 'action' => 'saveclick'],
	['lang' => $langs]
);
// ===========================================================================

Router::connect(
	'/:lang/:controller',
	['lang' => $lang, 'action' => 'index'],
	['lang' => $langs]
);

Router::connect(
	'/:lang/:controller/:action/*',
	['lang' => $lang],
	['lang' => $langs]
);

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();
Router::parseExtensions('xml');

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
