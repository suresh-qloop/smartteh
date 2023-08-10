<?php

App::uses('AppController', 'Controller');
App::uses('Theme', 'Model');

/**
 * Themes
 */
class ThemesController extends AppController
{
	public $name = 'Themes';

	/**
	 * @return void
	 */
	public function index(): void {
		$data = $this->Theme->findAll($this, 5);

		$urls = $this->commanIndexUrlGet('themes');

		$this->set(compact('data','urls'));
	}

	/**
	 * @param string $strid
	 *
	 * @return void
	 */
	public function view(string $strid): void {
		if (empty($strid)) {
			$this->redirect(['controller' => 'themes', 'action' => 'index'], 301);
		}

		$this->redirectFromIdToStrid($this->Theme, $strid, 'strid_'.$this->lang);

		$data = $this->Theme->findByStrid($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Theme->findByStrid($strid, $lang);
				if ($data && in_array($this->lang, $data['Theme']['translated'], true)) {
					$this->redirect(['action' => 'view', $data['Theme']['strid_'.$this->lang]]);
				}
			}

			throw new NotFoundException();
		}
		$urls = $this->commanUrlGet($this->lang,$strid,'Theme','themes');
		$this->set(compact('data', 'articles','urls'));
		$this->render('view');
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Theme->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Theme->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} else {
			$this->request->data['Theme']['date'] = date('Y-m-d');
		}

	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_update(int $id): void {
		if ($this->request->is(['post', 'put'])) {
			if ($this->Theme->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Theme.id');
		} else {
			$this->request->data = $this->Theme->getOrFail($id);
		}
		$this->set(compact('id'));

	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_metatags(int $id): void {
		$this->request->data = $this->Metatag->getData([
			'lang' => $this->lang,
			'controller' => $this->request->controller,
			'action' => 'view',
			'pid' => $id
		]);

		$this->set(compact('id'));
	}

	/**
	 * @param int $id
	 * @param bool|null $enabled
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_active(int $id, bool $enabled = null): void {
		$success = $this->Theme->active($id, $enabled);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_moveup(int $id): void {
		$success = $this->Theme->moveup($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_movedown(int $id): void {
		$success = $this->Theme->movedown($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		$this->Theme->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
