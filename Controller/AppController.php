<?php

App::uses('Controller', 'Controller');
App::uses('L10n', 'I18n');
App::uses('EmailTask', 'Console/Command/Task');

class AppController extends Controller
{
	public $uses = ['Setting', 'Metatag', 'Portfolio', 'Category', 'Industry', 'Service', 'Article'];

	public $components = ['Session', 'RequestHandler', 'Flash'];

	public $helpers = ['Form', 'AssetCompress.AssetCompress', 'Session', 'Html' => ['className' => 'CustomHtml']];

	public $meta = [];

	public $mobile = false;

	/**
	 * Function is executed before any controller logic
	 *
	 * Performs the following:
	 *  1. loads languages
	 *  2. denies access to admin panel if needed
	 *  3. loads admin layout if needed
	 *
	 * @return void
	 */
	public function beforeFilter()
	{

		$this->loadLanguage();

		// if user is not admin but is trying to open admin page, redirect to login
		if ($this->request->admin && !$this->Session->check('Admin')) {
			$this->Session->write('admin_redirect', '/' . $this->request->url);
			$this->redirect(['admin' => false, 'controller' => 'admins', 'action' => 'login']);
		} elseif ($this->request->is('ajax')) {
			$this->layout = 'ajax';
		} elseif ($this->request->admin) {
			$this->layout = 'admin/default';
		} else {
			$this->mobile = $this->request->isMobile() || str_starts_with(env('HTTP_HOST'), 'm.');
		}
	}

	// public function tempRedirect($language)
	// {
	// 	$supportedLanguages = array("en", "lv");

	// 	if (!in_array($language, $supportedLanguages)) {
	// 		$redirect = ['controller' => 'start', 'action' => 'index', 'lang' => $language];
	// 		$this->redirect($redirect);
	// 	}
	// }

	/**
	 * Function is executed before any page rendering
	 *
	 * Performs the following:
	 *  1. sets error layout in case of error (do not move this to beforeFilter)
	 *
	 * @return void
	 */
	public function beforeRender()
	{
		if ($this->name === 'CakeError') {
			$this->layout = 'error';

			return;
		}

		if (!empty($this->request->admin)) {
			// do admin stuff
			return;
		}

		if ($this->request->is('ajax')) {
			// do ajax stuff
			return;
		}

		$settings = $this->Setting->findList(['id', 'value'], false);

		$menu_blocks = [
			'portfolio' => $this->Portfolio->hasAnyActive($this->lang)
		];

		$menu_categories = $this->Category->findAllThreaded($this->lang, false);

		$menu_industries = $this->Industry->findAllActive();

		$menu_services = $this->Service->findAllActive();

		$menu_article = $this->Article->findAllActive();

		$mobile = $this->mobile;

		$default_metatag_img = $this->Setting->getValue('default-metatag-image', 'value');

		$this->set(compact('settings', 'menu_blocks', 'menu_categories', 'menu_industries', 'menu_article', 'mobile', 'menu_services', 'default_metatag_img'));

		if ($this->mobile) {
			$this->layout = 'mobile';
		}

		$this->loadMetatags();
	}

	/**
	 * Extend built-in redirect() by adding "lang" param
	 *
	 * See built-in redirect() for params and return info
	 *
	 * @param array|string $url
	 * @param int|null $status
	 * @param bool $exit
	 *
	 * @return CakeResponse|null
	 */
	public function redirect($url, $status = null, $exit = true)
	{
		if (is_array($url) && !isset($url['lang'])) {
			$url['lang'] = $this->lang;
		}

		return parent::redirect($url, $status, $exit);
	}

	/**
	 * Clear cache if needed
	 *
	 * @return void
	 */
	public function afterFilter()
	{
		$this->clearCacheIfNeeded();
	}

	/**
	 * Clear cache if needed
	 *
	 * @param array|string $url
	 * @param int|null $status
	 * @param bool $exit
	 *
	 * @return void
	 */
	public function beforeRedirect($url, $status = null, $exit = true)
	{
		$this->clearCacheIfNeeded();
	}

	/**
	 * If something was modified in cms with this request,
	 * clear all view cache files
	 *
	 * @return void
	 */
	public function clearCacheIfNeeded(): void
	{
		if (!Configure::read('Cache.check')) {
			return;
		}

		$actions = [
			'admin_update_external' => ['put', 'post'],
			'admin_create' => ['put', 'post'],
			'admin_update' => ['put', 'post'],
			'admin_missing' => ['put', 'post'],
			'admin_delete' => 'get',
			'admin_moveup' => 'get',
			'admin_active' => 'get',
			'admin_movedown' => 'get'
		];

		if (isset($actions[$this->request->action])) {
			$methods = (array)$actions[$this->request->action];

			foreach ($methods as $method) {
				if ($this->request->is($method)) {
					clearCache();

					return;
				}
			}
		}
	}

	/**
	 * Load current language (i18n and l10n)
	 *
	 * If no langauge is specified, set default
	 *
	 * Language from controllers can be accesses via $this->lang
	 * Language from views can be accesses via $lang
	 *
	 * @return void
	 */
	public function loadLanguage(): void
	{
		// if language is not set, set default
		if ($this->request->lang) {
			$this->lang = $this->request->lang;
		} elseif (!empty($this->request->named['lang'])) {
			$this->lang = $this->request->named['lang'];
		} else {
			$this->lang = Configure::read('Languages.default');
		}

		$this->set('lang', $this->lang);
		$this->set('langs', Configure::read('Languages.all'));

		// make lang available in all models
		foreach ($this->uses as $model) {
			$this->$model->lang = $this->lang;
		}

		$this->L10n = new L10n();
		$this->L10n->get($this->lang);

		Configure::write('Config.language', $this->lang);
	}

	/**
	 * Generic email sending function
	 *
	 * @param array $settings E-mail settings. Required params: to, template
	 * @param array|null $view_vars Variables to pass to view
	 *
	 * @return bool
	 */
	public function sendEmail(array $settings = [], array $view_vars = null): bool
	{
		$email = new EmailTask();

		return $email->send($settings, $view_vars);
	}

	/**
	 * Exit with specified JSON response
	 *
	 * @param array $response
	 *
	 * @return void
	 */
	public function jsonResponse(array $response = []): void
	{
		die(json_encode($response));
	}

	/**
	 * Exit with JSON error
	 *
	 * JSON format is as follows: {"status":0,"description":"Description of an error","title":"Error title"}
	 *
	 * @param string|null $description
	 * @param string|null $title
	 *
	 * @return void
	 */
	public function jsonError(string $description = null, string $title = null): void
	{
		if ($title === null) {
			$title = __d('admin', 'Error occured!');
		}

		$this->jsonResponse(['status' => 0, 'description' => $description, 'title' => $title]);
	}

	/**
	 * Exit with JSON success
	 *
	 * JSON format is as follows: {"status":1,"description":"Description of an success"}
	 * Most often description will be empty
	 *
	 * @param string|null $description
	 *
	 * @return void
	 */
	public function jsonSuccess(string $description = null): void
	{
		$this->jsonResponse(['status' => 1, 'description' => $description]);
	}

	/**
	 * Set or get (depending on request type) search data
	 *
	 * If request is POST, write data into Filter.X session, where X is current controller
	 * If request is GET, load data from Filter.X session into request->data object
	 */
	public function manageSearchRequest()
	{
		$key = 'Filter.' . $this->request->controller . '.' . $this->request->action;

		if ($this->request->is(['post', 'put'])) {
			$search = $this->request->data;
			$this->Session->write($key, $search);
		} else {
			$search = $this->Session->read($key);
			$this->request->data = $search;
		}

		return $search;
	}

	/**
	 * Respond properly after moveup/movedown/delete or similar action has been performed
	 *
	 * If we are coming from admin panel, redirect back (render same page), otherwise
	 * render admin_index. This is needed so deleting from frontend doesn't redirect
	 * us back to deleted page
	 *
	 * @param boolean $success Whether action was successfull
	 * @param array|string|null $redirect
	 *
	 * @return void
	 * @throws Exception
	 */
	public function actionResponse(bool $success, $redirect = null): void
	{
		if (!$this->request->is('ajax')) {
			if ($success) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} elseif (!$success) {
			throw new RuntimeException('');
		}

		if (str_contains($this->referer(), '/admin/')) {
			if (!$redirect) {
				$redirect = $this->referer();
			} elseif (is_string($redirect) && $this->request->is('ajax')) {
				if (!str_contains($redirect, '?')) {
					$redirect .= '?dnc=' . mt_rand();
				} else {
					$redirect .= '&dnc=' . mt_rand();
				}
			}
		} elseif (!$redirect) {
			$redirect = ['admin' => true, 'action' => 'index'];
		}

		$this->redirect($redirect);
	}

	/**
	 * Get and set metatags for current page
	 *
	 * @return void
	 */
	public function loadMetatags(): void
	{
		$controller = $this->meta['controller'] ?? $this->request->controller;

		$action = $this->meta['action'] ?? $this->request->action;

		if (isset($this->meta['pid'])) {
			$pid = $this->meta['pid'];
		} else {
			$pid = null;
			if (isset($this->viewVars['data']) && is_array($this->viewVars['data'])) {
				$data = current($this->viewVars['data']);

				if (isset($data['id'])) {
					$key = current(array_keys($this->viewVars['data']));

					if ($key === Inflector::classify($controller)) {
						$pid = $data['id'];
					}
				}
			}
		}

		$meta = $this->Metatag->getData([
			'lang' => $this->lang,
			'controller' => $controller,
			'action' => $action,
			'pid' => $pid
		], true);

		$this->set(compact('meta'));
	}

	/**
	 * Return rendered element
	 *
	 * @param string $file File name (without extension, must be in Elements directory)
	 * @param array $data Optional data to pass to view
	 *
	 * @return string Rendered html
	 */
	public function getRenderedElement(string $file, array $data = []): string
	{
		$this->autoRender = false;
		$view = new View($this, false);
		foreach ($data as $k => $v) {
			$view->set($k, $v);
		}
		$view->viewPath = 'Elements';

		return $view->render($file, 'ajax');
	}

	/**
	 * If needed, redirect current 'view' request with id param to strid param
	 *
	 * @param mixed $Model
	 * @param string $strid
	 * @param string $field
	 *
	 * @return void
	 */
	public function redirectFromIdToStrid($Model, string $strid, string $field = 'strid'): void
	{
		if (!is_numeric($strid)) {
			return;
		}

		$actual_strid = $Model->getValue($strid, $field);

		if (!$actual_strid) {
			return;
		}

		$this->redirect(['action' => 'view', $actual_strid], 301);
	}

	/**
	 * Exec command and in case of failure, throw error.
	 *
	 * @param string $command
	 *
	 * @return void
	 * @throws Exception
	 */
	public function execCommand(string $command): void
	{
		$output = [];
		$exit_code = [];

		exec($command . ' 2>&1', $output, $exit_code);

		if ($exit_code !== 0) {
			echo '<pre>';
			echo "<b>Command:</b>\n";
			echo $command . "\n\n";
			echo "<b>Exit code:</b>\n";
			echo $exit_code . "\n\n";
			echo "<b>Error:</b>\n";
			pr(trim(implode("\n", $output)));
			echo '</pre>';

			throw new RuntimeException('');
		}
	}
}
