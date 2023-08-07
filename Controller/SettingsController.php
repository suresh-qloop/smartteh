<?php

App::uses('AppController', 'Controller');

/**
 * Settings
 */
class SettingsController extends AppController
{
	public $name = 'Settings';

	public $uses = ['Setting'];

	/**
	 * @param int $id
	 *
	 * @return CakeResponse
	 */
	public function download(int $id): CakeResponse {
		$data = $this->Setting->get($id);

		if (!$data || $data['Setting']['type'] !== 'file') {
			throw new NotFoundException();
		}

		$this->response->file(APP.'webroot'.DS.'uploads'.DS.'settings'.DS.$data['Setting']['data'], [
			'download' => true
		]);

		return $this->response;
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$data = $this->Setting->adminList($this, 20);
		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Setting->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		}
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_update(int $id): void {
		if ($this->request->is(['post', 'put'])) {
			if ($this->Setting->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} else {
			$this->request->data = $this->Setting->getOrFail($id);
		}
	}

	/**
	 * @return void
	 */
	public function admin_clear_cache(): void {
		$paths = ['', 'assets', 'js', 'css', 'views', 'models', 'persistent'];

		foreach ($paths as $path) {
			clearCache(null, $path);
		}

		$this->Flash->success(__d('admin', 'MSG_OK'));
		$this->redirect($this->referer());
	}
}
