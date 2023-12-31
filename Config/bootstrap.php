<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', ['engine' => 'File']);

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *    'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *    'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *    'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *    array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *    array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', [
	'AssetDispatcher',
	'CacheDispatcher'
]);

CakePlugin::load('Migrations');

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', [
	'engine' => 'File',
	'types' => ['notice', 'info', 'debug'],
	'file' => 'debug',
]);
CakeLog::config('error', [
	'engine' => 'File',
	'types' => ['warning', 'error', 'critical', 'alert', 'emergency'],
	'file' => 'error',
]);

// custom changes below this comment

foreach (['cron', '404', 'emails'] as $name) {
	CakeLog::config('log_'.$name, [
		'scopes' => [$name],
		'file' => $name.'.log',
		'engine' => 'File'
	]);
}

// Local configuration file
include 'settings.php';

// Custom exception handler
App::uses('AppExceptionHandler', 'Lib');
App::uses('ConsoleExceptionHandler', 'Lib');

// Load specific plugins
CakePlugin::load('AssetCompress', ['bootstrap' => true]);

// Extend transliteration vocabulary for slug generation
Inflector::rules('transliteration', [
	'/À|Á|Â|Ã|Ä|Å|à|á|â|ã|ä|å|Ā|ā|Ă|ă|Ą|ą|А|а/' => 'a',
	'/Б|б/' => 'b',
	'/Ç|ç|Ć|ć|Ĉ|ĉ|Ċ|ċ|Č|č/' => 'c',
	'/Ч|ч/' => 'ch',
	'/Ď|ď|Đ|đ|Д|д/' => 'd',
	'/È|É|Ê|Ë|è|é|ê|ë|Ē|ē|Ĕ|ĕ|Ė|ė|Ę|ę|Ě|ě|Є|Е|Э|е|э|є/' => 'e',
	'/Ф|ф/' => 'f',
	'/Ĝ|ĝ|Ğ|ğ|Ġ|ġ|Ģ|ģ|Г|г|Ґ|ґ/' => 'g',
	'/Ĥ|ĥ|Ħ|ħ|Х|х/' => 'h',
	'/Ì|Í|Î|Ï|ì|í|î|ï|Ĩ|ĩ|Ī|ī|Ĭ|ĭ|Į|į|İ|ı|І|И|и|і/' => 'i',
	'/Ĳ|ĳ/' => 'ij',
	'/Ĵ|ĵ/' => 'j',
	'/Ķ|ķ|ĸ|К|к/' => 'k',
	'/Ĺ|ĺ|Ļ|ļ|Ľ|ľ|Ŀ|ŀ|Ł|ł|Л|л/' => 'l',
	'/М|м/' => 'm',
	'/Ñ|ñ|Ń|ń|Ņ|ņ|Ň|ň|ŉ|Ŋ|ŋ|Н|н/' => 'n',
	'/Ò|Ó|Ô|Õ|Ö|ò|ó|ô|õ|ö|ö|Ō|ō|Ŏ|ŏ|Ő|ő|О|о/' => 'o',
	'/Œ|œ/' => 'oe',
	'/П|п/' => 'p',
	'/Ŕ|ŕ|Ŗ|ŗ|Ř|ř|Р|р/' => 'r',
	'/ß|Ś|ś|Ŝ|ŝ|Ş|ş|Š|š|ſ|С|с/' => 's',
	'/Щ|щ/' => 'sch',
	'/Ш|ш/' => 'sh',
	'/Ţ|ţ|Ť|ť|Ŧ|ŧ|Т|т/' => 't',
	'/Ц|ц/' => 'ts',
	'/Ù|Ú|Û|Ü|ù|ú|û|ü|Ũ|ũ|Ū|ū|Ŭ|ŭ|Ů|ů|Ű|ű|Ų|ų|У|у/' => 'u',
	'/В|в/' => 'v',
	'/Ŵ|ŵ/' => 'w',
	'/Ý|ý|ÿ|Ŷ|ŷ|Ÿ|Й|й/' => 'y',
	'/Я|я/' => 'ya',
	'/Ї|Ы|ы|ї/' => 'yi',
	'/Ё|ё/' => 'yo',
	'/Ю|ю/' => 'yu',
	'/Ź|ź|Ż|ż|Ž|ž|З|з/' => 'z',
	'/Ж|ж/' => 'zh',
	'/€/' => 'eur',
	'/&/' => 'and'
]);

define('PIPEDRIVE_KEY', 'f684ad1188711003260aa0c2a763a83616057be4');
