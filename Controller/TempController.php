<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * For various tests and temporary functions.
 */
class TempController extends AppController
{
	/**
	 * @var string
	 */
	public $name = 'Temp';

	/**
	 * @var array
	 */
	public $uses = [];

	/**
	 * @var array
	 */
	public $components = [];

	/**
	 * Import all components.
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		foreach (App::objects('component') as $component) {
			$component = substr($component, 0, -9);
			$this->$component = $this->Components->load($component);
		}

		foreach (App::objects('model') as $model) {
			try {
				$this->loadModel($model);
			} catch (Exception $e) {
				// abstract or interface
			}
		}
	}

	/**
	 * @return void
	 */
	public function index(): void {
		die('OK');
	}

	/**
	 * @return void
	 */
	public function phpinfo(): void {
		if (!$this->Session->check('Admin')) {
			throw new MethodNotAllowedException;
		}

		die(phpinfo());
	}

	/**
	 * @param string $to
	 *
	 * @return void
	 */
	public function email(string $to): void {
		$r = $this->sendEmail([
			'to' => $to,
			'subject' => 'Test e-mail',
			'template' => 'test',
			'transactional' => true
		]);

		die($r ? 'OK' : 'ERR');
	}
}
